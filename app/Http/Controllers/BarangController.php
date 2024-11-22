<?php

namespace App\Http\Controllers;

use App\Models\barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;


class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brg =  barang::all();
		return view('barang.index', compact('brg'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('barang.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request):RedirectResponse
    {
        barang::create(['namabarang' => $request->namabarang]);
		return Redirect::to('/barang/lihat');
    }

    /**
     * Display the specified resource.
     */
    public function show(barang $barang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $brg = barang::where('id',$id)->first();
		return view('barang.create',compact('brg'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id = $request->id;
        $barang = barang::find($id);
        $barang->namabarang = $request->namabarang;
        $barang->save();
        return response()->json(['success' => 'Item updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $barang = barang::findOrFail($id);
        $barang->delete();
        return response()->json(['success' => 'Item deleted successfully.']);       
    }
}
