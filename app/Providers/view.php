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
       
    View::composer('layouts.sidebar', function ($view) {
        $menus = collect();
            if (Auth::check()){
               
                $roleId = Auth::user()->role_id;    
                // Fetch menus with access for the user's role
                $rawMenus = DB::select("
                    SELECT a.id AS menu_id, c.role_id , a.`name` AS menu_name , a.url AS menu_url , b.id AS submenu_id , b.url AS submenu_url ,b.name AS submenu_name , c.access FROM usermenu a
                    LEFT JOIN usersubmenu b ON a.id=b.menu_id 
                    LEFT JOIN useraccessmenu c ON  c.menu_id=a.id 
                    WHERE c.role_id=:role_id  AND c.access=1
                    ORDER BY a.id, b.id
                ", ['role_id' => $roleId]);

                  // Convert raw results to a grouped structure
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
                     dd($menus);
                }
                
        });
    }
}
