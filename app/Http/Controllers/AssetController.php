<?php

namespace App\Http\Controllers;

use App\Models\asset;
use App\Models\barang;
use App\Models\user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\PDF;
use Auth;
class AssetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $aset = Asset::all();
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
            'namapenginput' => 'required|string',
            'kdunitpenginput' => 'required|string',
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


    // Tambahkan method baru di AssetController
        public function getLantai(Request $request)
        {
            $lantai = DB::table('unit')
                ->where('kode_gedung', $request->kode_gedung)
                ->select('lantai')
                ->distinct()
                ->orderBy('lantai')
                ->get();

            return response()->json($lantai);
        }
        // Update method getUnits yang existing
        public function getUnitByLantai(Request $request)
        {
            try {
                $units = DB::table('unit')
                    ->where('kode_gedung', $request->kode_gedung)
                    ->where('lantai', $request->lantai)
                    ->select('nama_unit', 'kode_gedung')
                    ->get();
        
                return response()->json($units);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }

   
    public function laporan(Request $request)
    {
        $user=Auth::user();
        if(Auth::user()->role_id =='1' ||  Auth::user()->role_id=='5'){
           
            $x['nama_barang']=request('nama_barang');
            $x['no_serial']=request('no_serial');
            $x['kode_gedung']=request('kode_gedung');
            $x['unit']=request('unit');
            $x['lantai']=request('lantai');
            $x['semester']=request('semester');
            $x['tahun']=request('tahun');
            $x['satuan']=request('satuan');
            $x['masahidup']=request('masahidup');
            $x['penghapusan']=request('penghapusan');
            $x['perbaikan']=request('perbaikan');
            $aset = Asset::query();
            if($x['nama_barang'])
                $aset->where('nama_barang','=',$x['nama_barang']);
            if($x['no_serial'])
                $aset->where('no_serial','=',$x['no_serial']);
            if($x['kode_gedung'])
                $aset->where('kode_gedung','=',$x['kode_gedung']);
            if($x['unit'])
                $aset->where('unit','=',$x['unit']);
            if($x['lantai'])
                $aset->where('lantai','=',$x['lantai']);
            if($x['semester'])
                $aset->where('semester','=',$x['semester']);
            if($x['tahun'])
                $aset->where('tahun','=',$x['tahun']);           
            if($x['penghapusan'])
                $aset->where('penghapusan','=',$x['penghapusan']);
            if($x['perbaikan'])
                $aset->where('perbaikan','=',$x['perbaikan']);
            if($x['satuan'] && $x['masahidup'])
                $aset->where('satuan','=',$x['satuan'])
                     ->where('masahidup','=',$x['masahidup']);
            $aset = $aset->get();
            $data = [
                'title' => 'Laporan Aset',
                'user' => $user,
                'users' => User::all(),
                'gedung' => DB::table('gedung')->get(),
              
                'all_aset' => DB::table('aset')->get(),
                'aset' => $aset,
                'duplicate' => DB::table('aset')->count(),
                'brg' => DB::table('barang')->get(),
                'data_unit_mitra' => DB::connection('mitra')->table('gate.ms_unit')->get()
            ];
            return view('aset.laporan',$data);
        }else{           
            $x['nama_barang']=request('nama_barang');
            $x['no_serial']=request('no_serial');
            $x['kode_gedung']=request('kode_gedung');
            $x['unit']=request('unit');
            $x['lantai']=request('lantai');
            $x['semester']=request('semester');
            $x['tahun']=request('tahun');
            $x['satuan']=request('satuan');
            $x['masahidup']=request('masahidup');
            $x['penghapusan']=request('penghapusan');
            $x['perbaikan']=request('perbaikan');
            $aset = DB::table('aset')
            ->select('aset.*')
            ->where(function($aset) use($x){
                $aset->where('kdunitpenginput','=', Auth::user()->kodeunit);
            });
            if($x['nama_barang'])
                $aset->where('nama_barang','=',$x['nama_barang']);
            if($x['no_serial'])
                $aset->where('no_serial','=',$x['no_serial']);
            if($x['kode_gedung'])
                $aset->where('kode_gedung','=',$x['kode_gedung']);
            if($x['unit'])
                $aset->where('unit','=',$x['unit']);
            if($x['lantai'])
                $aset->where('lantai','=',$x['lantai']);
            if($x['semester'])
                $aset->where('semester','=',$x['semester']);
            if($x['tahun'])
                $aset->where('tahun','=',$x['tahun']);           
            if($x['penghapusan'])
                $aset->where('penghapusan','=',$x['penghapusan']);
            if($x['perbaikan'])
                $aset->where('perbaikan','=',$x['perbaikan']);
            if($x['satuan'] && $x['masahidup'])
                $aset->where('satuan','=',$x['satuan'])
                     ->where('masahidup','=',$x['masahidup']);
            $aset = $aset->get();
            $data = [
                'title' => 'Laporan Aset',
                'user' => $user,
                'users' => User::all(),
                'gedung' => DB::table('gedung')->get(),
               
                'all_aset' => DB::table('aset')->get(),
                'aset' => $aset,
                'duplicate' => DB::table('aset')->count(),
                'brg' => DB::table('barang')->get(),
                'data_unit_mitra' => DB::connection('mitra')->table('gate.ms_unit')->get()
            ];
            

            return view('aset.laporan', $data);
        }
        
            // return view('aset.laporan', $data);
    }

    // public function getUnits(Request $request)
    // {
    //         $units = DB::connection('mitra')
    //         ->table('gate.ms_unit')
    //         ->where('kode_gedung', $request->kode_gedung)
    //         ->select('namaunit', 'kodeunit')
    //         ->get();

    //     return response()->json($units);
    // }
    
    public function exportPdf()
    {
        $aset = Asset::with(['user', 'gedung'])->get();        
        // Implement PDF generation using a package like dompdf
        $pdf = PDF::loadView('aset.pdf', compact('aset'));        
        return $pdf->download('laporan-aset.pdf');
    }
    
}
