<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Mysqluser extends Authenticatable
{

	 
    protected $table = 'users'; // Nama tabel di PostgreSQL
    protected $fillable = ['username', 'password'];
}
