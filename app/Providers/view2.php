 	View::composer('layouts.partials.sidebar', function ($view) {
			//get all menu
            $roleId = Auth::user()->role_id;    
			$menus = DB::select("
                    SELECT a.* FROM usermenu a
                    LEFT JOIN useraccessmenu c ON  c.menu_id=a.id                    
                    WHERE c.role_id=$roleId  AND c.access=1
                    ORDER BY a.id
                ");
			// Ambil submenus tanpa menggunakan relasi otomatis
			$submenus =  DB::select("
                            SELECT b.* FROM usermenu a
                            LEFT JOIN usersubmenu b ON a.id=b.menu_id 
                            LEFT JOIN useraccessmenu c ON  c.menu_id=a.id                           
                            WHERE c.role_id=$roleId  AND c.access=1
                            ORDER BY a.id, b.id
                        ");
            foreach ($menus as $menu) {
				// Misalnya, jika submenus memiliki kolom 'menu_id' yang menghubungkan ke menu
				$menu->submenus = $submenus->where('menu_id', $menu->id);
			}	// Bagikan data menu dan submenus ke dalam view
			$view->with('menus', $menus);
		});