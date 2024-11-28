<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class gedung extends Model
{
    protected $table ='gedung';	
	protected $fillable=['kode_gedung','nama_gedung','imagegudang'];

    // public static function uploadImage($image)
    // {
    //     $filePath = null;

    //     if ($image) {
    //         $filePath = $image->store('uploads/gedung_images', 'public');
    //     }

    //     return $filePath;
    // }

    public function getImageUrlAttribute()
    {
        if ($this->imagegedung) {
            return asset('storage/gedung/' . $this->imagegedung);
        }
        return null;
    }

}
