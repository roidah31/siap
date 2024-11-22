<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class useraccessmemu extends Model
{
    protected $fillabel =['menu_id','role_id','access'];
	
	public function menu(){
		
		return $this->belongsTo(usermenu::class);
	}
	
	public function role(){
		return $this->belongsTo(role::class);
	}
}
