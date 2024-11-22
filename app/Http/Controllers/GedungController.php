<?php

namespace App\Http\Controllers;

use App\Models\gedung;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use DB;
class GedungController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index()
    {
        /*$gedungs = gedung::all();       
        return response()->json($gedungs);*/
		//return view('gedung.index',['ged'=>gedung::all]);
		
		$ged = gedung::all();
		return view('gedung.index',compact('ged'));
	
    }

    public function create(){
      return view('gedung.create');
    }

    //store with storage
    public function store(Request $request){
      $validated = $request->validate([
        'kode_gedung' => 'nullable|string|max:255',
        'nama_gedung' => 'nullable|string|max:255',
        'imagegedung' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Allow image only
      ]);
      $imagePath = null;
      // Handle image upload
      if ($request->hasFile('imagegedung')) {
          $image = $request->file('imagegedung');
          // Check for potentially malicious content in the file
          if (!in_array($image->getMimeType(), ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'])) {
              return response()->json(['message' => 'Invalid file type!'], 422);
          }
          $imagePath = gedung::uploadImage($request->file('imagegedung'));
          $data = new gedung();
          $data->kode_gedung = $request->kode_gedung;
          $data->nama_gedung =$request->nama_gedung;
          $data->imagegedung = $imagePath;
          $data->save();
      }
     
      $data = new gedung();
      $data->kode_gedung = $request->kode_gedung;
      $data->nama_gedung =$request->nama_gedung;
    
      $data->save();
      return response()->json(['success' => 'Gedung successfully created!']);     
     }

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
            $imagePath = gedung::uploadImage($request->file('imagegedung'));
    
            // Update gambar pada model gedung
            $gedung->imagegedung = $imagePath;
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
