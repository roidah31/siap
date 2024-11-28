<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class useraccessmenu extends Model
{
	protected $table ='useraccessmenu';
    protected $fillabel =['menu_id','role_id','access'];
	public function menu()
		{
			return $this->belongsTo(usermenu::class, 'menu_id');
		}
	
}
