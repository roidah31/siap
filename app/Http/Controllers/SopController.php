<?php

namespace App\Http\Controllers;

use App\Models\sop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\IOFactory as WordIOFactory;
use PhpOffice\PhpSpreadsheet\IOFactory as SpreadsheetIOFactory;
use Smalot\PdfParser\Parser as PdfParser;
use Illuminate\Support\Facades\Log;
//secure addons
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class SopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private function processAndStoreFile($file, $directory = 'sop')
    {
        // Generate file hash before moving it to storage
        $fileHash = hash_file('sha256', $file->getPathname());
        
        // Create filename with timestamp
        $fileName = time() . '_' . $file->getClientOriginalName();
        
        // Store file
        $filePath = $file->storeAs($directory, $fileName, 'public');
        
        return [
            'path' => $filePath,
            'hash' => $fileHash,
            'original_name' => $file->getClientOriginalName()
        ];
    }

    public function index()
    {
        $sop = sop::all();
        return view('sop.index',compact('sop'));
    }

  
    /**
     * Store a newly created resource in storage.
     */
      public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'kategori' => 'required|string|max:255',
                'filesop' => 'required|file|mimes:pdf,doc,docx,xls,xlsx|max:10240'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            $data = new sop();
            $data->kategori = $request->kategori;

            if ($request->hasFile('filesop')) {
                $fileInfo = $this->processAndStoreFile($request->file('filesop'));
                
                $data->filesop = $fileInfo['path'];
                $data->file_hash = $fileInfo['hash'];
                $data->original_filename = $fileInfo['original_name'];
            }

            $data->save();

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil disimpan',
                'file_hash' => $data->file_hash
            ]);

        } catch (\Exception $e) {
            Log::error('Error in SopController@store: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan data: ' . $e->getMessage()
            ], 500);
        }
    }

    private function readDocContent($file)
    {
        $phpWord = IOFactory::load($file->getPathname());
        $text = '';

        foreach ($phpWord->getSections() as $section) {
            foreach ($section->getElements() as $element) {
                if (method_exists($element, 'getText')) {
                    $text .= $element->getText() . ' ';
                }
            }
        }

        return $text;
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:sop,id',
                'kategori' => 'required|string|max:255',
                'filesop' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:10240'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            $data = sop::findOrFail($request->id);
            $data->kategori = $request->kategori;

            if ($request->hasFile('filesop')) {
                // Delete old file if exists
                if ($data->filesop) {
                    Storage::disk('public')->delete($data->filesop);
                }

                // Process and store new file
                $fileInfo = $this->processAndStoreFile($request->file('filesop'));
                
                $data->filesop = $fileInfo['path'];
                $data->file_hash = $fileInfo['hash'];
                $data->original_filename = $fileInfo['original_name'];
            }

            $data->save();

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diupdate',
                'file_hash' => $data->file_hash
            ]);

        } catch (\Exception $e) {
            Log::error('Error in SopController@update: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupdate data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $sop = sop::findorFail($id);
        if($sop->filesop){
            Storage::disk('public')->delete($sop->filesop);
        }
        $sop->delete();
        return response()->json(['success'=>'Data sop successfully deleted! ']);

    }

    //Download section with secure url 
    private function generateSecureDownloadUrl($sopId)
    {
        // Generate random token
        $token = Str::random(64);
        
        // Store token in cache for 1 hour with SOP ID
        Cache::put('download_token_' . $token, $sopId, now()->addHour());
        
        // Encrypt token
        $encryptedToken = Crypt::encryptString($token);
        
        return route('sop.secure-download', ['token' => $encryptedToken]);
    }

    /**
     * Handle secure download with token
     */
    public function getSecureDownloadUrl($id)
    {
        try {
            $sop = Sop::findOrFail($id);
            $downloadUrl = $this->generateSecureDownloadUrl($sop->id);
            
            return response()->json([
                'success' => true,
                'download_url' => $downloadUrl
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error generating download link'
            ], 500);
        }
    }
    
    public function handleSecureDownload($token)
    {
        try {
            // Decrypt token
            $decryptedToken = Crypt::decryptString($token);
            
            // Get SOP ID from cache
            $sopId = Cache::get('download_token_' . $decryptedToken);
            
            if (!$sopId) {
                abort(403, 'Invalid or expired download link');
            }
            
            // Get SOP record
            $sop = Sop::findOrFail($sopId);
            
            if (!$sop->filesop || !Storage::disk('public')->exists($sop->filesop)) {
                abort(404, 'File not found');
            }
            
            // Delete token from cache after use
            Cache::forget('download_token_' . $decryptedToken);
            $previousUrl = url()->previous();
            // Return file for download
            return Storage::disk('public')->download(
                $sop->filesop,
                $sop->original_filename
            );

        } catch (\Exception $e) {
            abort(500, 'Error processing download');
        }
    }
    

  
}
