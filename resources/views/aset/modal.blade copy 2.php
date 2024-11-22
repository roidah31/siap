<div class="modal bs-example-modal-lg fade" id="bs-example-modal-lg" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah unit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Start of Form -->
                <form id="form-add-unit" action="{{URL('/aset/store')}}" method="POST">
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
                        <label for="no_serial" class="form-label">Serial No</label>
                        <input type="text" id="no_serial" class="form-control" placeholder="Serial no" name="no_serial">
                    </div>
                    <div class="mb-3">
                        <label for="fungsi_barang" class="form-label">Fungsi Barang</label>
                        <input type="text" class="form-control" id="fungsi_barang" name="fungsi_barang" required>
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
                        <label for="unit" class="form-label">UNit</label>
                        <select id="unit" class="form-control" name="unit">
                            <option value="">Pilih Unit</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="ruang" class="form-label">Ruang</label>
                        <input id="ruang" class="form-control" name="ruang">                        
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
                    
                    </div>
                    <div class="mb-3">
                        <label for="unit" class="form-label">Masa hidup</label>                       
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

                </form>
                <!-- End of Form -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <!-- Remove the Submit Button to fully automate -->
            </div>
        </div>
    </div>
</div>

<!-- Edit form -->
<!-- Modal for Editing Unit -->
<div class="modal" id="modal-edit-barang" tabindex="-1" role="dialog" aria-labelledby="modal-edit-barangLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-edit-barangLabel">Edit Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="edit-form">
                    <input type="text" id="edit-id" name="id">
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
                        <label for="no_serial" class="form-label">Serial No</label>
                        <input type="text" id="no_serial" class="form-control" placeholder="Serial no" name="no_serial">
                    </div>
                    <div class="mb-3">
                        <label for="fungsi_barang" class="form-label">Fungsi Barang</label>
                        <input type="text" class="form-control" id="fungsi_barang" name="fungsi_barang" required>
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
                        <label for="unit" class="form-label">UNit</label>
                        <select id="unit" class="form-control" name="unit">
                            <option value="">Pilih Unit</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="ruang" class="form-label">Ruang</label>
                        <input id="ruang" class="form-control" name="ruang">                        
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
                    
                    </div>
                    <div class="mb-3">
                        <label for="unit" class="form-label">Masa hidup</label>                       
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
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
<script>
$(document).ready(function () {
    let namaBarangChoices, unitMitraChoices, gedungChoices, lantaiChoices, unitChoices;

    // Fungsi untuk inisialisasi Choices.js (tetap sama)
    function initializeChoices(elementId, instance) {
        console.log(`Initializing Choices.js for: #${elementId}`);
        const element = document.getElementById(elementId);
        if (!element) {
            console.error(`Element with ID '${elementId}' not found.`);
            return null;
        }
        if (instance && typeof instance.destroy === 'function') {
            instance.destroy();
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

    // Event handler untuk modal add
    $('#bs-example-modal-lg').on('hide.bs.modal', function (e) {
        // Validasi form sebelum submit
        const form = $('#form-add-unit')[0];
        if (!form.checkValidity()) {
            e.preventDefault(); // Mencegah modal tertutup
            alert('Mohon lengkapi semua field yang diperlukan');
            return false;
        }

        const formData = $('#form-add-unit').serialize();
        console.log('Submitting form data:', formData); // Debug log

        $.ajax({
            url: $('#form-add-unit').attr('action') || window.location.pathname,
            method: 'POST',
            data: formData,
            beforeSend: function() {
                console.log('Sending AJAX request...'); // Debug log
            },
            success: function (response) {
                console.log('Success response:', response); // Debug log
                alert('Data berhasil ditambahkan!');
                location.reload();
            },
            error: function (xhr, status, error) {
                console.error('Error details:', {
                    status: xhr.status,
                    statusText: xhr.statusText,
                    responseText: xhr.responseText
                });
                alert('Gagal menyimpan data: ' + (xhr.responseJSON?.message || error));
                $('#bs-example-modal-lg').modal('show'); // Buka kembali modal jika ada error
            }
        });
    });

    // Event handler untuk modal edit
    // $('#modal-edit-unit').on('hide.bs.modal', function (e) {
    //     // Validasi form sebelum submit
    //     const form = $('#form-edit-unit')[0];
    //     if (!form.checkValidity()) {
    //         e.preventDefault(); // Mencegah modal tertutup
    //         alert('Mohon lengkapi semua field yang diperlukan');
    //         return false;
    //     }

    //     const formData = $('#form-edit-unit').serialize();
    //     const id = $('#edit-id').val();
        
    //     $.ajax({
    //         url: `/aset/update/${id}`,
    //         method: 'PUT',
    //         data: formData,
    //         beforeSend: function() {
    //             console.log('Sending update request...'); // Debug log
    //         },
    //         success: function (response) {
    //             console.log('Update success:', response); // Debug log
    //             alert('Data berhasil diperbarui!');
    //             location.reload();
    //         },
    //         error: function (xhr, status, error) {
    //             console.error('Update error details:', {
    //                 status: xhr.status,
    //                 statusText: xhr.statusText,
    //                 responseText: xhr.responseText
    //             });
    //             alert('Gagal memperbarui data: ' + (xhr.responseJSON?.message || error));
    //             $('#modal-edit-unit').modal('show'); // Buka kembali modal jika ada error
    //         }
    //     });
    // });

    // Event handler untuk unit changed (tetap sama)
    $('#lantai').on('change', function () {
        const kode_gedung = $('#kode_gedung').val();
        const lantai = $(this).val();

        if (kode_gedung && lantai) {
            $.ajax({
                url: '/api/get-units',
                method: 'GET',
                data: { kode_gedung: kode_gedung, lantai: lantai },
                success: function (response) {
                    console.log('Units fetched:', response);

                    if (Array.isArray(response) && response.length > 0) {
                        const unitDropdown = document.getElementById('unit');
                        unitDropdown.innerHTML = '<option value="">Pilih Unit</option>';

                        response.forEach(function (item) {
                            const option = document.createElement('option');
                            option.value = item.nama_unit;
                            option.textContent = item.nama_unit;
                            unitDropdown.appendChild(option);
                        });

                        if (unitChoices && typeof unitChoices.destroy === 'function') {
                            unitChoices.destroy();
                        }
                        unitChoices = initializeChoices('unit', unitChoices);
                    } else {
                        console.log('No units found');
                        alert('Data unit kosong atau tidak valid.');
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error fetching units:', xhr.responseText);
                    alert('Gagal memuat data unit.');
                }
            });
        } else {
            $('#unit').html('<option value="">Pilih Unit</option>');
            if (unitChoices && typeof unitChoices.destroy === 'function') {
                unitChoices.destroy();
            }
            unitChoices = initializeChoices('unit', unitChoices);
        }
    });

  


    // Edit Process
    $('.edit-button').on('click', function () {
        var item = $(this).data('item'); // Get item data from button
        // Check if item data exists
        if (item) {
            $('#edit-id').val(item.id); // Set the hidden ID field
            $('#edit-kode-barang').val(item.kode_barang); // Set the Kode Barang field
            $('#edit-nama-barang').val(item.namabarang); // Set the Nama Barang field
        }

        $('#modal-edit-barang').modal('show');
    });
    // Automatically submit the update form when the modal is hidden (or closed)
    $('#modal-edit-barang').on('hidden.bs.modal', function () {
        if ($('#edit-id').val()) { // Ensure there is an ID to update
            var formData = {
                id: $('#edit-id').val(),
                kode_barang: $('#edit-kode-barang').val(),
                namabarang: $('#edit-nama-barang').val(),
                _token: $('meta[name="csrf-token"]').attr('content') // Include CSRF token
            };

            var id = $('#edit-id').val();

            $.ajax({
                url: '{{URL('/barangubah')}}',
                method: "POST",
                data: formData,
                success: function (response) {
                    alert("Data updated successfully!");
                    location.reload(); // Reload to reflect changes
                },
                error: function (xhr, status, error) {
                    alert("Failed to update data. Please try again.");
                }
            });
        }
    });

 
});


    

</script>