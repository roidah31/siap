<?php

namespace App\Http\Controllers;

use App\Models\gedung;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class GedungController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index()
    {
     
		
		$ged = gedung::all();
		return view('gedung.index',compact('ged'));
	
    }

    public function create(){
      return view('gedung.create');
    }

    //store with storage
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'kode_gedung' => 'required|string|max:255|unique:gedung',
                'nama_gedung' => 'required|string|max:255',
                'imagegedung' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
            ]);

            $gedung = new gedung();
            $gedung->kode_gedung = $request->kode_gedung;
            $gedung->nama_gedung = $request->nama_gedung;

            // Handle image upload
            if ($request->hasFile('imagegedung')) {
                $file = $request->file('imagegedung');
                
                // Make sure the file is valid
                if ($file->isValid()) {
                    // Create a unique filename
                    $fileName = time() . '_' . Str::slug($request->nama_gedung) . '.' . $file->getClientOriginalExtension();
                    // Make sure the directory exists
                    $path = storage_path('app/public/gedung');
                    if (!file_exists($path)) {
                        mkdir($path, 0777, true);
                    }
                    // Move the file to the storage directory
                    $file->move($path, $fileName);
                    // Save the filename to the database
                    $gedung->imagegedung = $fileName;
                }
            }
            $gedung->save();
            return response()->json([
                'success' => true,
                'message' => 'Data gedung berhasil disimpan',
                'data' => $gedung
            ]);

        } catch (\Exception $e) {
            \Log::error('Gedung Store Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }


    // public function edit($id)
    // {
    //     $gedungs = Gedung::findOrFail($id);
    //     return response()->json(['data' => $gedungs]);
    // }


     public function update(Request $request)
    {
        $id = $request->gedungId;

        // Validasi input request
        $request->validate([
            'nama_gedung' => 'nullable|string|max:255',
            'kode_gedung' => 'nullable|string|max:10',       
            'imagegedung' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        // Temukan gedung berdasarkan ID
        $gedung = gedung::findOrFail($id);
    
        // Jika ada file gambar yang diupload
        if ($request->hasFile('imagegedung')) {
            $image = $request->file('imagegedung');   
                    
            // Pastikan file yang diupload adalah gambar yang valid
            if (!in_array($image->getMimeType(), ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'])) {
                return response()->json(['message' => 'Invalid file type!'], 422);
            }
            // Proses upload gambar
            // $imagePath = gedung::uploadImage($request->file('imagegedung'));
            $fileName = time() . '_' . Str::slug($request->nama_gedung) . '.' . $image->getClientOriginalExtension();
            $path = storage_path('app/public/gedung');
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            // Move the file to the storage directory
            $image->move($path, $fileName);
            // Save the filename to the database
            $gedung->imagegedung = $fileName;
            // $gedung->imagegedung = $imagePath;
        }
    
        // Update kode dan nama gedung jika ada perubahan
        if ($request->has('kode_gedung')) {
            $gedung->kode_gedung = $request->kode_gedung;
        }
    
        if ($request->has('nama_gedung')) {
            $gedung->nama_gedung = $request->nama_gedung;
        }
    
        // Simpan perubahan ke database
        $gedung->save();
    
        return response()->json(['success' => 'Data has been updated successfully!']);
    }

    public function destroy($id)
    {
        $gedung = gedung::findOrFail($id);
        // Delete the associated image if exists
        if ($gedung->imagegedung) {
            Storage::disk('public')->delete($gedung->imagegedung);
        }
        $gedung->delete();
        return response()->json(['success' => 'Data has been deleted successfully!']);
    }

    // Fetch data api gedung 
    public function getNamaGedung(Request $request)
    {
        $kodeGedung = $request->kode_gedung;
            $namaGedung = DB::table('gedung')->where('kode_gedung', $kodeGedung)->value('nama_gedung'); // Ambil nama_gedung
            return response()->json(['nama_gedung' => $namaGedung]);
    }

    public function getKodeGedung()
    {
        $data = DB::table('gedung')->select('kode_gedung','nama_gedung')->get(); // Ambil data kode_gedung
    return response()->json($data);
    }

 

    
}
