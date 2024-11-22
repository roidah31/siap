@extends('layouts.admin')
@section('content')
<section class="content">
<div class="row">
<div class="col-12">
<div class="col-lg-6 col-12">
					<!-- Basic Forms -->
					  <div class="box">
						<div class="box-header with-border">
						  <h4 class="box-title">Form Sections</h4>
						</div>
						<!-- /.box-header -->
						<form id="form-unit"   action="{{URL('/aset/store')}}" method="POST">
                    @csrf  <!-- CSRF token for Laravel -->             
                    <div class="mb-3">
                        <div class="form-group">
                            <label for="nama_barang" class="form-label">Nama Barang</label>
                            <select class="form-control" id="nama_barang" name="nama_barang">
                                <option value="">Pilih Barang</option>
                                @foreach($brg as $r)
                                    <option value="{{ $r->id }}">{{ $r->namabarang }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="unit" class="form-label">Unit</label>
                        <select name="unit_mitra" id="unit_mitra" class="form-control "  required>
                        <option value="">Pilih Barang</option>
                                @foreach($kdUnit as $r)
                                    <option value="{{ $r->namaunit }}">{{ $r->namaunit }}</option>
                                @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="nama_gedung" class="form-label">Serial No</label>
                        <input type="text" id="nama_gedung" class="form-control" placeholder="Nama Gedung" name="nama_gedung">
                    </div>
                    <div class="mb-3">
                        <label for="fungsi_barang" class="form-label">Fungsi Barang</label>
                        <input type="number" class="form-control" id="fungsi_barang" name="fungsi_barang" required>
                    </div>
                    <!-- Gedung -->
                    <div class="mb-3">
                        <label for="kode_gedung" class="form-label">Gedung</label>
                        <select id="kode_gedung" class="form-control" name="kode_gedung">
                            <option value="">Pilih Gedung</option>
                            @foreach($gedung as $r)
                                <option value="{{ $r->kode_gedung }}">{{ $r->nama_gedung }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Lantai -->
                    <div class="mb-3">
                        <label for="lantai" class="form-label">Lantai</label>
                        <select id="lantai" class="form-control" name="lantai">
                            <option value="">Pilih Lantai</option>
                            <option value="1"> 1</option>
                            <option value="2"> 2</option>
                            <option value="3"> 3</option>
                        </select>
                    </div>

                    <!-- Unit -->
                    <div class="mb-3">
                        <label for="unit" class="form-label">Ruang</label>
                        <select id="unit" class="form-control" name="unit">
                            <option value="">Pilih ruang</option>
                        </select>
                    </div>
                    <!-- Waktu pengadaan -->
                    <div class="mb-3">
                        <label for="unit" class="form-label">Waktu pengadaan</label>
                        <select id="semester" class="form-control" name="semester">
                                    <option disabled selected>--PILIH--</option>
                                    <option value="ganjil">GANJIL</option>
                                    <option value="genap">GENAP</option>
                        </select>
                    </div>
                    <!-- Tahun -->
                    <div class="mb-3">
                        <label for="unit" class="form-label">Tahun</label>
                        <select name="tahun" id="tahun" class="form-control">
                            <?php
                            for($i=date('Y'); $i>=date('Y')-32; $i-=1){
                                echo"<option value='$i'> $i </option>";
                            }
                            ?>
                        </select>
                    </div>
                    <!-- MASA HIDUP  -->
                    <div class="mb-3">
                        <label for="unit" class="form-label">Tahun</label>
                        <select class="form-control" id="satuan" name="satuan" required>
                            <option disabled selected>--BULAN/TAHUN--</option>
                            <option value="Tahun">Tahun</option>
                            <option value="Bulan">Bulan</option>
                        </select>
                        <div class="form-group col-sm-6" style=" display: table-cell;">
                            <input type="number" class="form-control form-control-user" id="masahidup" name="masahidup" placeholder="Masa Hidup">
                        </div>
                    </div>
                    <!-- Penghapusan -->
                    <div class="mb-3">
                        <label for="unit" class="form-label">Penghapusan</label>                             
                        <div class="form-group col-sm-6" style=" display: table-cell;">
                            <input type="date" class="form-control form-control-user" id="penghapusan" name="penghapusan" placeholder="Penghapusan">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="unit" class="form-label">PERBAIKAN :</label>                             
                        <div class="form-group col-sm-6" style=" display: table-cell;">
                            <input type="date" class="form-control form-control-user" id="perbaikan" name="perbaikan" placeholder="Perbaikan">
                        <label for="unit" class="form-label">PERBAIKAN KE:</label>                             
                        <div class="form-group col-sm-6" style=" display: table-cell;">
                            <input type="number" class="form-control form-control-user" id="perbaikanke" name="perbaikanke" placeholder="Perbaikan Ke -">
                        </div>
                    </div>
                    <!-- Waktu pengadaan -->
                    <div class="mb-3">
                        <label for="unit" class="form-label">KONDISI :</label>
                                <select class="form-control" id="status" name="status" required>
                                    <option disabled selected>--PILIH--</option>
                                    <option value="0">BAIK</option>
                                    <option value="1">RUSAK RINGAN</option>
                                    <option value="2">RUSAK BERAT</option>
                                    <option value="3">HILANG</option>
                                </select>
                    </div>
					<div class="modal-footer">
							<button type="submit" class="btn btn-secondary" value="submit">simpan</button>
							<!-- Remove the Submit Button to fully automate -->
						</div>
                </form>
                <!-- End of Form -->
            </div>
           
					  <!-- /.box -->			
				</div>
</div>
</div>
</section>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
<script>
$(document).ready(function () {
    let namaBarangChoices, unitMitraChoices, gedungChoices, lantaiChoices, unitChoices;

    // Fungsi untuk inisialisasi Choices.js
    function initializeChoices(elementId, instance) {
        console.log(`Initializing Choices.js for: #${elementId}`);
        const element = document.getElementById(elementId);
        if (!element) {
            console.error(`Element with ID '${elementId}' not found.`);
            return null; // Hentikan jika elemen tidak ditemukan
        }
        if (instance && typeof instance.destroy === 'function') {
            instance.destroy(); // Hapus instance jika sudah ada
        }
        try {
            return new Choices(element, {
                searchEnabled: true,
                itemSelectText: '',
                removeItemButton: false,
                shouldSort: false,
            });
        } catch (error) {
            console.error(`Error initializing Choices.js for: #${elementId}`, error);
            return null;
        }
    }

    // Inisialisasi Choices.js untuk semua dropdown
    namaBarangChoices = initializeChoices('nama_barang', namaBarangChoices);
    unitMitraChoices = initializeChoices('unit_mitra', unitMitraChoices);
    gedungChoices = initializeChoices('kode_gedung', gedungChoices);
    lantaiChoices = initializeChoices('lantai', lantaiChoices);
    unitChoices = initializeChoices('unit', unitChoices);

    // Fetch Unit berdasarkan Gedung dan Lantai
    $('#lantai').on('change', function () {
        const kode_gedung = $('#kode_gedung').val();
        const lantai = $(this).val();

        if (kode_gedung && lantai) {
            $.ajax({
            url: '/api/get-units', // Endpoint untuk mendapatkan unit berdasarkan gedung dan lantai
            method: 'GET',
            data: { kode_gedung: kode_gedung, lantai: lantai },
            success: function (response) {
                console.log('Units fetched response:', response); // Debug respons API

                if (Array.isArray(response) && response.length > 0) {
                    const unitDropdown = document.getElementById('unit');
                    unitDropdown.innerHTML = '<option value="">Pilih Unit</option>'; // Reset opsi awal

                    response.forEach(function (item) {
                        const option = document.createElement('option');
                            option.value = item.nama_unit; // Atur ID atau nilai yang sesuai
                            option.textContent = item.nama_unit; // Tampilkan nama unit
                        unitDropdown.appendChild(option);
                    });

                    // Refresh Choices.js untuk unit
                    if (unitChoices && typeof unitChoices.destroy === 'function') {
                        unitChoices.destroy();
                    }
                    unitChoices = initializeChoices('unit', unitChoices);
                } else {
                    alert('Data unit kosong atau tidak valid.');
                }
            },
            error: function (xhr, status, error) {
                console.error('Error fetching units:', xhr.responseText);
                alert('Gagal memuat data unit.');
            },
        });
    } else {
        // Reset dropdown unit jika gedung atau lantai tidak valid
        $('#unit').html('<option value="">Pilih Unit</option>');
        if (unitChoices && typeof unitChoices.destroy === 'function') {
            unitChoices.destroy();
        }
        unitChoices = initializeChoices('unit', unitChoices);
        }   
    });

    // Proses Simpan
 
    // Proses Edit
    $('#edit-form').on('change', ':input', function () {
        const id = $('#edit-id').val(); // Ambil ID dari hidden input
        const formData = $('#edit-form').serialize();
        $.ajax({
            url: `/aset/update/${id}`,
            method: 'PUT',
            data: formData,
            success: function (response) {
                alert(response.message);
                location.reload(); // Reload untuk melihat perubahan data
            },
            error: function (xhr) {
                alert('Gagal memperbarui data!');
                console.error(xhr.responseText);
            }
        });
    });

    // Proses Delete
    $('#form-delete-unit').on('submit', function (e) {
        e.preventDefault();
        const id = $('#delete-id').val(); // Ambil ID dari hidden input
        $.ajax({
            url: `/aset/delete/${id}`,
            method: 'DELETE',
            data: {
                _token: $('input[name="_token"]').val() // CSRF token
            },
            success: function (response) {
                alert(response.message);
                location.reload(); // Reload untuk melihat perubahan data
            },
            error: function (xhr) {
                alert('Gagal menghapus data!');
                console.error(xhr.responseText);
            }
        });
    });

    // Validasi wajib dropdown
    $('#form-unit select').on('change', function () {
        if ($(this).val() === '') {
            alert('Field ini wajib diisi!');
        }
    });
});


</script>
@endsection