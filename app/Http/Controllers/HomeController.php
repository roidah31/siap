<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Psgdbuser;
use App\Models\User;
use DB;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
         $username = auth()->user()->username;

        // Ambil data user dari postgre Mitra 
        $pgsqlProfile = DB::connection('mitra')->table('gate.sc_user')
            ->where('username', $username)
            ->first();

        // Ambil data user dari mysql 
        $mysqlProfile = DB::table('users')
            ->where('username', $username)
            ->first();

        // Join kedua table
        $profile = (object) array_merge((array) $pgsqlProfile, (array) $mysqlProfile);
        return view('home', compact('profile'));		
		//return view('home');
    }
}
