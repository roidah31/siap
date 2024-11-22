<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class role extends Model
{
    protected $fillable = ['name'];
	protected $table ='role';
	public function Useraccessmenu(){
		return $this->hasMany(useraccessmenu::class);
	}
}
