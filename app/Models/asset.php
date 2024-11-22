<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class asset extends Model
{
    protected $fillable = [
	'nama_barang' ,
	'fungsi_barang' ,
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
}
