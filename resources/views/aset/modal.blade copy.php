
<div class="modal modal-right fade" id="modal-right" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah unit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Start of Form -->
                <form id="form-unit">
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
                        <label for="lantai" class="form-label">Fungsi Barang</label>
                        <input type="number" class="form-control" id="lantai" name="lantai" required>
                    </div>
                    <div class="mb-3">
                        <label for="kode_gedung" class="form-label">Gedung</label>
                        <input type="text" class="form-control" id="kode_gedung" name="kode_gedung" required>
                        <select id="kode_gedung" class="form-control" name="kode_gedung">
                            <option value="">Pilih Gedung</option>
                            @foreach($ged as $r)
                                <option value="{{ $r->kode_gedung }}">{{ $r->nama_gedung }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="lantai" class="form-label">Lantai</label>
                        <select id="lantai" class="form-control" name="lantai">
                            <option value="">Pilih Lantai</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="nama_unit" class="form-label">unit gedung</label>
                        <select id="unit" class="form-control" name="unit">
                            <option value="">Pilih Unit</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="nama_unit" class="form-label">Waktu pengadaan barang</label>
                        <input type="text" class="form-control" id="nama_unit" name="nama_unit" required>
                    </div>
                    <!-- Add more fields as needed -->
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
<!-- Modal Edit  -->
<div class="modal" id="modal-edit-unit" tabindex="-1" role="dialog" aria-labelledby="modal-edit-unitLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-edit-unitLabel">Edit unit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="edit-form">
                    <input type="text" id="edit-id" name="id">
                    <div class="form-group">
                        <label for="edit-namabarang">Kode unit</label>
                        <input type="text" class="form-control" id="edit-namabarang" name="namabarang">
                    </div>
                    <div class="form-group">
                        <label for="edit-nama-gedung">Nama Gedung</label>
                        <input type="text" class="form-control" id="edit-nama-unit" name="nama_gedung">
                    </div>                   
                    <div class="form-group">
                        <label for="edit-lantai">Lantai</label>
                        <input type="text" class="form-control" id="edit-lantai" name="lantai">
                    </div>
                    <div class="form-group">
                        <label for="edit-nama-unit">Nama unit</label>
                        <input type="text" class="form-control" id="edit-nama-unit" name="nama_unit">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



<!-- Modal Delete Conf -->
<div class="modal fade" id="modal-delete-unit" tabindex="-1" aria-labelledby="modalDeleteunitLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDeleteunitLabel">Delete unit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this item?</p>
                <form id="form-delete-unit">
                    @csrf
                    @method('DELETE')  <!-- Specify DELETE method for deletions -->
                    <input type="hidden" id="delete-id" name="id">  <!-- Hidden field for ID -->
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" onclick="submitDeleteForm()">Delete</button>
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

    // Inisialisasi Choices.js
    function initializeChoices(elementId, instance) {
        const element = document.getElementById(elementId);
        if (instance) {
            instance.destroy(); // Hapus instance jika sudah ada
        }
        return new Choices(element, {
            searchEnabled: true,
            itemSelectText: '',
            removeItemButton: false,
            shouldSort: false
        });
    }

    // Inisialisasi Choices.js untuk dropdown
    gedungChoices = initializeChoices('kode_gedung', gedungChoices);
    lantaiChoices = initializeChoices('lantai', lantaiChoices);
    unitChoices = initializeChoices('unit', unitChoices);

    // Fetch Lantai berdasarkan Gedung
    $('#kode_gedung').on('change', function () {
        const kodeGedung = $(this).val();

        if (kodeGedung) {
            $.ajax({
                url: '/api/get-lantai',
                method: 'GET',
                data: { kode_gedung: kodeGedung },
                success: function (response) {
                    // Update dropdown lantai
                    const lantaiDropdown = document.getElementById('lantai');
                    lantaiDropdown.innerHTML = '<option value="">Pilih Lantai</option>';
                    response.forEach(function (item) {
                        const option = document.createElement('option');
                        option.value = item;
                        option.textContent = `Lantai ${item}`;
                        lantaiDropdown.appendChild(option);
                    });

                    // Refresh Choices.js untuk lantai
                    lantaiChoices.destroy();
                    lantaiChoices = initializeChoices('lantai', lantaiChoices);
                },
                error: function () {
                    alert('Gagal memuat data lantai.');
                }
            });
        } else {
            // Reset dropdown lantai dan unit
            $('#lantai').html('<option value="">Pilih Lantai</option>');
            $('#unit').html('<option value="">Pilih Unit</option>');
            lantaiChoices.destroy();
            unitChoices.destroy();
            lantaiChoices = initializeChoices('lantai', lantaiChoices);
            unitChoices = initializeChoices('unit', unitChoices);
        }
    });

    // Fetch Unit berdasarkan Gedung dan Lantai
    $('#lantai').on('change', function () {
        const kodeGedung = $('#kode_gedung').val();
        const lantai = $(this).val();

        if (kodeGedung && lantai) {
            $.ajax({
                url: '/api/get-unit',
                method: 'GET',
                data: { kode_gedung: kodeGedung, lantai: lantai },
                success: function (response) {
                    // Update dropdown unit
                    const unitDropdown = document.getElementById('unit');
                    unitDropdown.innerHTML = '<option value="">Pilih Unit</option>';
                    response.forEach(function (item) {
                        const option = document.createElement('option');
                        option.value = item;
                        option.textContent = item;
                        unitDropdown.appendChild(option);
                    });

                    // Refresh Choices.js untuk unit
                    unitChoices.destroy();
                    unitChoices = initializeChoices('unit', unitChoices);
                },
                error: function () {
                    alert('Gagal memuat data unit.');
                }
            });
        } else {
            // Reset dropdown unit
            $('#unit').html('<option value="">Pilih Unit</option>');
            unitChoices.destroy();
            unitChoices = initializeChoices('unit', unitChoices);
        }
    });



    // Fungsi untuk inisialisasi Choices.js
    function initializeChoices(elementId, instance) {
        const element = document.getElementById(elementId);
        if (instance) {
            instance.destroy(); // Hapus instance jika sudah ada
        }
        return new Choices(element, {
            searchEnabled: true,  // Mengaktifkan pencarian
            itemSelectText: '',   // Menghapus teks default di dropdown
            removeItemButton: false,  // Tidak ada tombol hapus item
            shouldSort: false     // Tidak mengurutkan opsi
        });
    }

    // Inisialisasi Choices.js saat modal dibuka
    $('#modal-right').on('shown.bs.modal', function () {
        namaBarangChoices = initializeChoices('nama_barang', namaBarangChoices);
        unitMitraChoices = initializeChoices('unit_mitra', unitMitraChoices);
    });

    // Hancurkan Choices.js saat modal ditutup
    $('#modal-right').on('hidden.bs.modal', function () {
        if (namaBarangChoices) {
            namaBarangChoices.destroy();
            namaBarangChoices = null;
        }
        if (unitMitraChoices) {
            unitMitraChoices.destroy();
            unitMitraChoices = null;
        }
    });
    // Gedung + unit
    
   

    // Inisialisasi Choices.js
    function initializeChoices(elementId, instance) {
        const element = document.getElementById(elementId);
        if (instance) {
            instance.destroy(); // Hapus instance jika sudah ada
        }
        return new Choices(element, {
            searchEnabled: true,
            itemSelectText: '',
            removeItemButton: false,
            shouldSort: false
        });
    }

    // Inisialisasi Choices.js untuk dropdown
    gedungChoices = initializeChoices('kode_gedung', gedungChoices);
    lantaiChoices = initializeChoices('lantai', lantaiChoices);
    unitChoices = initializeChoices('unit', unitChoices);

    // Fetch Lantai berdasarkan Gedung
    $('#kode_gedung').on('change', function () {
        const kodeGedung = $(this).val();

        if (kodeGedung) {
            $.ajax({
                url: '/api/get-lantai',
                method: 'GET',
                data: { kode_gedung: kodeGedung },
                success: function (response) {
                    // Update dropdown lantai
                    const lantaiDropdown = document.getElementById('lantai');
                    lantaiDropdown.innerHTML = '<option value="">Pilih Lantai</option>';
                    response.forEach(function (item) {
                        const option = document.createElement('option');
                        option.value = item;
                        option.textContent = `Lantai ${item}`;
                        lantaiDropdown.appendChild(option);
                    });

                    // Refresh Choices.js untuk lantai
                    lantaiChoices.destroy();
                    lantaiChoices = initializeChoices('lantai', lantaiChoices);
                },
                error: function () {
                    alert('Gagal memuat data lantai.');
                }
            });
        } else {
            // Reset dropdown lantai dan unit
            $('#lantai').html('<option value="">Pilih Lantai</option>');
            $('#unit').html('<option value="">Pilih Unit</option>');
            lantaiChoices.destroy();
            unitChoices.destroy();
            lantaiChoices = initializeChoices('lantai', lantaiChoices);
            unitChoices = initializeChoices('unit', unitChoices);
        }
    });

    // Fetch Unit berdasarkan Gedung dan Lantai
    $('#lantai').on('change', function () {
        const kodeGedung = $('#kode_gedung').val();
        const lantai = $(this).val();

        if (kodeGedung && lantai) {
            $.ajax({
                url: '/api/get-unit',
                method: 'GET',
                data: { kode_gedung: kodeGedung, lantai: lantai },
                success: function (response) {
                    // Update dropdown unit
                    const unitDropdown = document.getElementById('unit');
                    unitDropdown.innerHTML = '<option value="">Pilih Unit</option>';
                    response.forEach(function (item) {
                        const option = document.createElement('option');
                        option.value = item;
                        option.textContent = item;
                        unitDropdown.appendChild(option);
                    });

                    // Refresh Choices.js untuk unit
                    unitChoices.destroy();
                    unitChoices = initializeChoices('unit', unitChoices);
                },
                error: function () {
                    alert('Gagal memuat data unit.');
                }
            });
        } else {
            // Reset dropdown unit
            $('#unit').html('<option value="">Pilih Unit</option>');
            unitChoices.destroy();
            unitChoices = initializeChoices('unit', unitChoices);
        }
    });




});


</script>