<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Psgdbuser;
use App\Models\User;
use App\Models\useraccessmenu;
use App\Models\usermenu;
use App\Models\usersubmenu;
use App\Models\Role;
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
       
        $user = Auth::user();
        if (Auth::check()){
            $roleId = Auth::user()->role_id;    
            // Fetch menus with access for the user's role
            $rawMenus = DB::select("
                SELECT a.id AS menu_id, c.role_id , a.`name` AS menu_name , a.url AS menu_url , b.id AS submenu_id , b.url AS submenu_url  , b.name AS submenu_name ,c.access FROM usermenu a
                LEFT JOIN usersubmenu b ON a.id=b.menu_id 
                LEFT JOIN useraccessmenu c ON  c.menu_id=a.id 
                WHERE c.role_id=:role_id  AND c.access=1
                ORDER BY a.id, b.id
            ", ['role_id' => $roleId]);

            $menus = collect($rawMenus)->groupBy('menu_id')->map(function ($items) {
                $menu = $items->first();
                return [
                    'id' => $menu->menu_id,
                    'name' => $menu->menu_name,
                    'url' => $menu->menu_url,
                    'submenus' => $items->filter(fn($item) => $item->submenu_id)->map(function ($submenu) {
                        return [
                            'id' => $submenu->submenu_id,
                            'name' => $submenu->submenu_name,
                            'url' => $submenu->submenu_url,
                        ];
                    })->values(),
                ];
            })->values();
            // dd($menus);
        }
		
	
    }

   
}
