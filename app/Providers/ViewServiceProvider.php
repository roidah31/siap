<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Models\UserAccessMenu;
use App\Models\UserMenu;
use App\Models\UserSubMenu;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('layouts.partials.sidebar', function ($view) {
			
			// $menus = UserMenu::all();
            $roleId = Auth::user()->role_id;    
			$menus = DB::select("
                    SELECT a.* FROM usermenu a
                    LEFT JOIN useraccessmenu c ON  c.menu_id=a.id                    
                    WHERE c.role_id=$roleId  AND c.access=1
                    ORDER BY a.id
                ");
			// Ambil submenus tanpa menggunakan relasi otomatis
			$submenus = \DB::table('usersubmenu')->get();foreach ($menus as $menu) {
				// Misalnya, jika submenus memiliki kolom 'menu_id' yang menghubungkan ke menu
				$menu->submenus = $submenus->where('menu_id', $menu->id);
			}	// Bagikan data menu dan submenus ke dalam view
			$view->with('menus', $menus);
		});
    
    }
}
