<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Models\UserAccessMenu;
use App\Models\UserMenu;
use App\Models\UserSubMenu;
use App\Models\Role;

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
         //meload menu ke semua layout 
       /*View::composer('layouts.partials.sidebar', function ($view) {
            $user = Auth::user();

            if ($user) {
                // Get role IDs associated with the authenticated user
                $roleIds = $user->roles->pluck('id');

                // Get menu IDs based on role access
                $menuIds = UserAccessMenu::whereIn('role_id', $roleIds)
                    ->where('access', true)
                    ->pluck('menu_id');

                // Fetch menus that the user has access to, along with accessible submenus
                $menus = UserMenu::whereIn('id', $menuIds)
                    ->with(['submenus' => function ($query) use ($roleIds) {
                        // Filter submenus based on access
                        $query->whereHas('accesses', function ($accessQuery) use ($roleIds) {
                            $accessQuery->whereIn('role_id', $roleIds)->where('access', true);
                        });
                    }])
                    ->get();

                // Share the menu data with the view
                $view->with('menus', $menus);
            }
        });*/
		View::composer('layouts.partials.sidebar', function ($view) {
			//get all menu
			$menus = UserMenu::all();
			// Ambil submenus tanpa menggunakan relasi otomatis
			$submenus = \DB::table('usersubmenu')->get();foreach ($menus as $menu) {
				// Misalnya, jika submenus memiliki kolom 'menu_id' yang menghubungkan ke menu
				$menu->submenus = $submenus->where('menu_id', $menu->id);
			}	// Bagikan data menu dan submenus ke dalam view
			$view->with('menus', $menus);
		});


    }
}
