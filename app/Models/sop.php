<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class sop extends Model
{
    use HasFactory;

    protected $table="sop";
    protected $fillable = ['kategori','filesop'];

    public static function uploadFile($filesop)
    {
        $filePath = null;

        if ($filesop) {
            $filePath = $filesop->store('uploads/file_sop', 'public');
        }

        return $filePath;
    }
}
