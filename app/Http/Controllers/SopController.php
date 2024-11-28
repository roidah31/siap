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
use Illuminate\Support\Facades\Response;


//secure addons
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class SopController extends Controller
{

    public function index()
    {
        $sop = sop::all();
        return view('sop.index',compact('sop'));
    }

   

    private function processAndStoreFile($file, $directory = 'sop')
    {
        try {
            $fileHash = hash_file('sha256', $file->getPathname());        
            $fileName = time() . '_' . Str::slug($file->getClientOriginalName());
            
            // Get storage path
            $filePath = storage_path('app/public/sop');
            
            // Create directory if doesn't exist
            if (!file_exists($filePath)) {
                mkdir($filePath, 0755, true);
            }
            
            // Move file
            $file->move($filePath, $fileName);
            
            return [
                'path' => $fileName,
                'hash' => $fileHash,
                'original_name' => $file->getClientOriginalName()
            ];
        } catch (\Exception $e) {
            Log::error('File processing error: ' . $e->getMessage());
            throw $e;
        }
    }

    private function generateSecureDownloadUrl($sopId)
    {
        try {
            $token = Str::random(64);
            Cache::put('download_token_' . $token, $sopId, now()->addMinutes(30));
            $encryptedToken = Crypt::encryptString($token);
            return route('sop.download', ['token' => $encryptedToken]);
        } catch (\Exception $e) {
            Log::error('Error generating download URL: ' . $e->getMessage());
            throw $e;
        }
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
                $files = $request->file('filesop');
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


    public function create(){
        return view('sop.create');
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
        try {
            $sop = Sop::findOrFail($id);
            $filePath = 'app/public/sop/' . basename($sop->filesop);
            
            if ($sop->filesop && file_exists(storage_path($filePath))) {
                unlink(storage_path($filePath));
            }
            
            $sop->delete();
            return response()->json(['success' => 'Data SOP berhasil dihapus!']);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false, 
                'message' => 'Error deleting SOP: ' . $e->getMessage()
            ], 500);
        }
    }


    public function getDownloadUrl($id)
    {
        try {
            $sop = Sop::findOrFail($id);
            $filePath = storage_path('app/public/sop/' . $sop->filesop);
            
            if (!file_exists($filePath)) {
                return response()->json([
                    'success' => false,
                    'message' => 'File tidak ditemukan'
                ], 404);
            }

            $downloadUrl = $this->generateSecureDownloadUrl($sop->id);
            return response()->json([
                'success' => true,
                'download_url' => $downloadUrl
            ]);

        } catch (\Exception $e) {
            Log::error('Download URL generation error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal generate link download'
            ], 500);
        }
    }

    public function download($token)
    {
        try {
            $decryptedToken = Crypt::decryptString($token);
            $sopId = Cache::get('download_token_' . $decryptedToken);
            
            if (!$sopId) {
                throw new \Exception('Link download tidak valid atau expired');
            }

            $sop = Sop::findOrFail($sopId);
            $filePath = storage_path('app/public/sop/' . $sop->filesop);

            if (!file_exists($filePath)) {
                throw new \Exception('File tidak ditemukan');
            }

            $mimeType = mime_content_type($filePath) ?: 'application/octet-stream';
            Cache::forget('download_token_' . $decryptedToken);

            return Response::download(
                $filePath,
                $sop->original_filename,
                [
                    'Content-Type' => $mimeType,
                    'Content-Disposition' => 'attachment; filename="' . $sop->original_filename . '"'
                ]
            );

        } catch (\Exception $e) {
            Log::error('Download error: ' . $e->getMessage());
            abort(500, 'Gagal memproses download: ' . $e->getMessage());
        }
    }
    
    

  
}
