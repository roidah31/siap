<?php

namespace App\Http\Controllers;

use App\Models\usermenu;
use Illuminate\Http\Request;

class UsermenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /*public function index()
    {
        $menus = usermenu::with('usersubmenu')->get();
		return view('menu.index',compact('menus'));
    }*/
	
	public function index()
    {
        $user = Auth::user();
        $roleIds = $user->roles->pluck('id'); // Ambil role ID user

        // Ambil menu yang aksesnya sesuai dengan role user
        $menus = Menu::whereHas('accesses', function ($query) use ($roleIds) {
            $query->whereIn('role_id', $roleIds)->where('access', true);
        })->with('submenus')->get();

		//return ke layout sidebar
        return view('layouts.partials.sidebar', compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(usermenu $usermenu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(usermenu $usermenu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, usermenu $usermenu)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(usermenu $usermenu)
    {
        //
    }
}
