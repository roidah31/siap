<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class usermenu extends Model
{
	protected $fillable = ['name', 'url'];    
    protected $table = 'usermenu';
    // Definisikan relasi hasMany dengan UserSubmenu, gunakan nama 'submenus'
    public function submenus()
    {
        return $this->hasMany(UserSubmenu::class);
    }
	

}
