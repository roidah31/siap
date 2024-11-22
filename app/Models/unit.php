<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class unit extends Model
{
    protected $fillable =['kode_gedung','nama_gedung','nama_unit','lantai'];
    protected $table='unit';
}
