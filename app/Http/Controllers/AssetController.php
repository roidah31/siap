<?php

namespace App\Http\Controllers;

use App\Models\asset;
use App\Models\barang;
use Illuminate\Http\Request;
use DB;
class AssetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $aset = asset::all();
        $kdUnit = DB::connection('mitra')->table('gate.ms_unit')->select('namaunit')    
        ->get();
        $brg = DB::table('barang')->get();
        $gedung = DB::table('gedung')->get();
        return view('aset.index', compact('aset','brg','gedung','kdUnit'));
   
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $aset = asset::all();
        $kdUnit = DB::connection('mitra')->table('gate.ms_unit')->select('namaunit')    
        ->get();
        $brg = DB::table('barang')->get();
        $gedung = DB::table('gedung')->get();
        return view('aset.create', compact('aset','brg','gedung','kdUnit'));
    }

    /**
     * Store a newly created resource in storage.
     */
       public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'nama_barang' => 'required',
            'unit_mitra' => 'required',
            'kode_gedung' => 'required',
            'lantai' => 'required',
            'unit' => 'required',
            'fungsi_barang' => 'nullable|string',
            'semester' => 'nullable',
            'tahun' => 'nullable|integer',
            'satuan' => 'nullable|string',
            'masahidup' => 'nullable|integer',
            'penghapusan' => 'nullable|date',
            'perbaikan' => 'nullable|date',
            'perbaikanke' => 'nullable|integer',
            'status' => 'nullable|integer',
            'no_serial' => 'nullable|string',
            'ruang' => 'nullable|string',
        ]);

        // Simpan data ke database
        $asset = Asset::create($validatedData);
        return response()->json([
            'success' => true,
            'message' => 'Data berhasil disimpan!',
            'data' => $asset
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // Validasi input
        $id= $request->id;
        $validatedData = $request->validate([
            'nama_barang' => 'required|string',
            'unit_mitra' => 'required|string',
            'kode_gedung' => 'required|string',
            'lantai' => 'required',
            'unit' => 'required',
            'fungsi_barang' => 'nullable|string',
            'semester' => 'nullable',
            'tahun' => 'nullable|integer',
            'satuan' => 'nullable|string',
            'masahidup' => 'nullable|integer',
            'penghapusan' => 'nullable|date',
            'perbaikan' => 'nullable|date',
            'perbaikanke' => 'nullable|integer',
            'status' => 'nullable|integer',
            'no_serial' => 'nullable|string',
            'ruang' => 'nullable|string',
        ]);

        // Update data
        $asset = Asset::findOrFail($id);
        $asset->update($validatedData);

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diperbarui!',
            'data' => $asset
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,$id)
    {
        $id = $request->id;
        $barang = Asset::findOrFail($id);
        $barang->delete();

        return redirect(route('aset.index'))->with(['success' => 'Deleted']);
    }


    /**
     * Get Data APi route 
     */
   

    public function getNamaBarang()
    {
        $data = DB::table('barang')->select('namabarang')->get(); // Ambil data kode_gedung
        return response()->json($data);
    }

    public function getUnit()
    {
        $data = DB::connection('mitra')->table('gate.ms_unit')->select('namaunit')->get();
        return response()->json($data);
    }
}
