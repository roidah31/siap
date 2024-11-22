<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class barang extends Model
{
    protected $table = 'barang';
    public $timestamps = false;
	protected $fillable = ['namabarang'];
}
