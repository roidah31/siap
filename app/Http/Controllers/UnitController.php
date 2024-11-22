<?php

namespace App\Http\Controllers;

use App\Models\unit;
use App\Models\gedung;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $unit = unit::all();
        $ged = gedung::all();
        return view('unit.index',compact('unit','ged'));
        return view('unit.model',[ 
            'ged'=>gedung::get(['kode_gedung','nama_gedung'])
        ]); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('unit.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
 
        $data = new unit();
        $data->kode_gedung = $request->kode_gedung;
        $data->nama_gedung = $request->nama_gedung;
        $data->lantai = $request->lantai;
        $data->nama_unit = $request->nama_unit;
        $data->save();         

        var_dump($data);

        // return response()->json(['success'=>"Data Unit has been successfully saved! "]);
    }

    public function destroy($id)
    {
        $unt = unit::findOrFail($id);
        // Delete the associated image if exists
        if ($unt->imagegedung) {
            Storage::disk('public')->delete($unt->imagegedung);
        }
        $unt->delete();
        return response()->json(['success' => 'Data has been deleted successfully!']);
    }

    public function update(Request $request)
    {
        $id = $request->id;
        

        $val = $request->validate([
            'nama_gedung' => 'string|max:255',
            'kode_gedung' => 'string|max:10',       
            'lantai' => 'integer',
            'nama_unit'=>'string',
        ]);
        try {
            $unit = unit::findOrFail($request->id);
            $unit->update($val);
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }


    /**
     * Display the specified resource.
     */
     // Fetch unit berdasarkan kode_gedung dan lantai
     public function getUnits(Request $request)
     {
         $kodeGedung = $request->input('kode_gedung');
         $lantai = $request->input('lantai');
 
        //  if ($kodeGedung && $lantai) {
             $units = Unit::where('kode_gedung', $kodeGedung)
                 ->where('lantai', $lantai)
                 ->select('nama_unit')
                    ->get();
             return response()->json($units);
        //  }
 
         return response()->json([], 400); // Jika data tidak valid
     }
  
}
