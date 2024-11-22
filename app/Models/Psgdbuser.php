<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Psgdbuser extends Authenticatable
{
     protected $connection = 'mitra'; // Koneksi ke PostgreSQL
    protected $table = 'gate.sc_user'; // Nama tabel di PostgreSQL
    protected $fillable = ['username', 'password'];
}
