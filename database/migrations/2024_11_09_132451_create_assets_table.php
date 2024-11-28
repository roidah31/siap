<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('aset', function (Blueprint $table) {
            $table->id();
            $table->string('nama_barang');
            $table->string('fungsi_barang');
            $table->string('unit_mitra');
            $table->string('kode_gedung');
            $table->string('unit');
            $table->integer('lantai');
            $table->string('ruang');
            $table->string('semester');
            $table->integer('tahun');
            $table->string('kondisi_baik');
            $table->string('kondisi_rusak_ringan');
            $table->string('kondisi_rusak_berat');
            $table->string('hilang');
            $table->integer('total');
            $table->integer('namapenginput');
            $table->string('kdunitpenginput');
            $table->string('status');
            $table->integer('satuan');
            $table->integer('masahidup');
            $table->date('penghapusan');
            $table->date('perbaikan');
            $table->string('perbaikanke');
            $table->string('no_serial');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aset');
    }
};
