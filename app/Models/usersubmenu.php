<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class usersubmenu extends Model
{
	protected $fillable = ['name', 'url', 'icon', 'is_active'];
    protected $table = 'usersubmenu';

    // Relasi balik ke UserMenu
    public function userMenu()
    {
        return $this->belongsTo(UserMenu::class);
    }
	
}
