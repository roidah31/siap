<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class asset extends Model
{
    protected $fillable = [
	'nama_barang' ,
	'fungsi_barang',
    'unit_mitra',
	'kode_gedung' ,
	'unit' ,
	'lantai' ,
	'ruang' ,
	'semester' ,
	'tahun' ,
	'kondisi_baik' ,
	'kondisi_rusak_ringan' ,
	'kondisi_rusak_berat' ,
	'hilang' ,
	'total' ,
	'namapenginput' ,
	'kdunitpenginput' ,
	'status' ,
	'satuan' ,
	'masahidup' ,
	'penghapusan' ,
	'perbaikan' ,
	'perbaikanke' ,
	'no_serial' ,
	'created_at' ,
	'updated_at'
    ];

    protected $table='aset';
    public $timestamps = false;


	public function user()
    {
        return $this->belongsTo(User::class, 'namapenginput', 'username');
    }

    public function gedung()
    {
        return $this->belongsTo(Gedung::class, 'kode_gedung', 'kode_gedung');
    }

    // public function unit_mitra()
    // {
    //     return $this->belongsTo(UnitMitra::class, 'kdunitpenginput', 'kodeunit');
    // }

    public function getStatusTextAttribute()
    {
        return match($this->status) {
            '0' => 'BAIK',
            '1' => 'RUSAK RINGAN',
            '2' => 'RUSAK BERAT',
            '3' => 'HILANG',
            default => ''
        };
    }
}
