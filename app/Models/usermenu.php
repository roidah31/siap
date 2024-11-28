<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class usermenu extends Model
{
	protected $fillable = ['name', 'url'];    
    protected $table = 'usermenu';
    public function useraccessmenu()
    {
        return $this->hasMany(useraccessmenu::class, 'menu_id');
    }
    public function submenu()
    {
        return $this->hasMany(usersubmenu::class, 'menu_id');
    }

}
