
<style>
.required:after {
    content: " *";
    color: red;
}

.modal-lg {
    max-width: 900px;
}

.form-label {
    font-weight: 500;
}

.invalid-feedback {
    font-size: 80%;
}

/* Custom styling untuk Choices.js */
/* .choices__inner {
    padding: 4px 8px;
    min-height: 38px;
    border-radius: 4px;
}

.choices__input {
    background-color: transparent;
} */

/* .choices__list--dropdown {
    z-index: 1056;
} */

 /* Custom Toastr Styling */
.toast-success {
    background-color: #198754 !important; /* Bootstrap success green */
}

.toast-error {
    background-color: #dc3545 !important; /* Bootstrap danger red */
}

.toast-info {
    background-color: #0dcaf0 !important; /* Bootstrap info blue */
}

.toast-warning {
    background-color: #ffc107 !important; /* Bootstrap warning yellow */
    color: #000 !important; /* Dark text for better visibility on yellow */
}

/* Progress bar colors */
.toast-success .toast-progress {
    background-color: #146c43;
}

.toast-error .toast-progress {
    background-color: #b02a37;
}

.toast-info .toast-progress {
    background-color: #0aa2c0;
}

.toast-warning .toast-progress {
    background-color: #cc9a06;
}

</style>

<!-- Modal Form -->
<div class="modal fade" id="formModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Tambah Data Aset</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                  <form id="asetForm" action="{{Route('aset.store')}}" method="POST">
                    @csrf
                    <input type="hidden" id="aset_id" name="id">
                    <input type="hidden" id="form_type" name="form_type" value="add">
                    <input type="hidden" class="form-control" id="namapenginput" name="namapenginput" value="{{ AUTH::user()->username}}">
                    <input type="hidden" class="form-control" id="kdunitpenginput" name="kdunitpenginput" value="{{ AUTH::user()->kodeunit}}">
                    <!-- Nama Barang -->
                    <div class="mb-3">
                        <div class="form-group">
                            <label for="nama_barang" class="form-label">Nama Barang</label>
                            <select class="form-control" id="nama_barang" name="nama_barang" required>
                                <option value="">Pilih Barang</option>
                                @foreach($brg as $r)
                                    <option value="{{ $r->namabarang }}">{{ $r->namabarang }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Unit Mitra -->
                    <div class="mb-3">
                        <label for="unit_mitra" class="form-label">Unit</label>
                        <select name="unit_mitra" id="unit_mitra" class="form-control" required>
                            <option value="">Pilih Unit</option>
                            @foreach($kdUnit as $r)
                                <option value="{{ $r->namaunit }}">{{ $r->namaunit }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- No Serial -->
                    <div class="mb-3">
                        <label for="no_serial" class="form-label">Serial No</label>
                        <input type="text" id="no_serial" class="form-control" placeholder="Serial no" name="no_serial" required>
                    </div>

                    <!-- Fungsi Barang -->
                    <div class="mb-3">
                        <label for="fungsi_barang" class="form-label">Fungsi Barang</label>
                        <input type="text" class="form-control" id="fungsi_barang" name="fungsi_barang" required>
                    </div>

                    <!-- Lokasi Section -->
                    <div class="row">
                        <!-- Gedung -->
                        <div class="col-md-4 mb-3">
                            <label for="kode_gedung" class="form-label">Gedung</label>
                            <select id="kode_gedung" class="form-control" name="kode_gedung" required>
                                <option value="">Pilih Gedung</option>
                                @foreach($gedung as $r)
                                    <option value="{{ $r->kode_gedung }}">{{ $r->nama_gedung }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Lantai -->
                        <div class="col-md-4 mb-3">
                            <label for="lantai" class="form-label">Lantai</label>
                            <select id="lantai" class="form-control" name="lantai" required>
                                <option value="">Pilih Lantai</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                            </select>
                        </div>
                        <!-- Unit -->
                        <div class="col-md-4 mb-3">
                            <label for="unit" class="form-label">Unit</label>
                            <select id="unit" class="form-control" name="unit" required>
                                <option value="">Pilih Unit</option>
                            </select>
                        </div>
                    </div>
                    <!-- Ruang -->
                    <div class="mb-3">
                        <label for="ruang" class="form-label">Ruang</label>
                        <input id="ruang" class="form-control" name="ruang" required>
                    </div>

                    <!-- Waktu Section -->
                    <div class="row">
                        <!-- Semester -->
                        <div class="col-md-6 mb-3">
                            <label for="semester" class="form-label">Semester</label>
                            <select id="semester" class="form-control" name="semester" required>
                                <option value="">--PILIH--</option>
                                <option value="ganjil">GANJIL</option>
                                <option value="genap">GENAP</option>
                            </select>
                        </div>

                        <!-- Tahun -->
                        <div class="col-md-6 mb-3">
                            <label for="tahun" class="form-label">Tahun</label>
                            <select name="tahun" id="tahun" class="form-control" required>
                                <option value="">--PILIH--</option>
                                <?php
                                for($i=date('Y'); $i>=date('Y')-32; $i-=1){
                                    echo"<option value='$i'> $i </option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <!-- Masa Hidup Section -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="satuan" class="form-label">Satuan Masa Hidup</label>
                            <select class="form-control" id="satuan" name="satuan" required>
                                <option value="">--BULAN/TAHUN--</option>
                                <option value="Tahun">Tahun</option>
                                <option value="Bulan">Bulan</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="masahidup" class="form-label">Masa Hidup</label>
                            <input type="number" class="form-control" id="masahidup" name="masahidup" required>
                        </div>
                    </div>
                    <!-- Penghapusan dan Perbaikan -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="penghapusan" class="form-label">Penghapusan</label>
                            <input type="date" class="form-control" id="penghapusan" name="penghapusan">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="perbaikan" class="form-label">Perbaikan</label>
                            <input type="date" class="form-control" id="perbaikan" name="perbaikan">
                        </div>
                    </div>
                    <!-- Perbaikan Ke -->
                    <div class="mb-3">
                        <label for="perbaikanke" class="form-label">Perbaikan Ke-</label>
                        <input type="number" class="form-control" id="perbaikanke" name="perbaikanke">
                    </div>

                    <!-- Status -->
                    <div class="mb-3">
                        <label for="status" class="form-label">Kondisi</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="">--PILIH--</option>
                            <option value="0">BAIK</option>
                            <option value="1">RUSAK RINGAN</option>
                            <option value="2">RUSAK BERAT</option>
                            <option value="3">HILANG</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="btnSave">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Form -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css" rel="stylesheet">


<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>


<script>
$(document).ready(function () {
    let choicesInstances = {};
    let formChanged = false;
    let initialFormData = '';
    
    // Configure Toastr options
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };
    
    const choicesFields = [
        'nama_barang', 'unit_mitra', 'kode_gedung', 'lantai', 
        'unit', 'semester', 'tahun', 'satuan', 'status'
    ];

    function initializeChoices() {
        choicesFields.forEach(field => {
            const element = document.getElementById(field);
            if (element) {
                if (choicesInstances[field]) {
                    choicesInstances[field].destroy();
                }
                choicesInstances[field] = new Choices(element, {
                    searchEnabled: true,
                    itemSelectText: '',
                    removeItemButton: false,
                    shouldSort: false,
                    classNames: {
                        containerInner: 'form-select'
                    }
                });
            }
        });
        setupDependentDropdowns();
    }

    function setupDependentDropdowns() {
        if (choicesInstances.kode_gedung) {
            choicesInstances.kode_gedung.passedElement.element.addEventListener(
                'change',
                function(event) {
                    const kodeGedung = event.target.value;
                    if (kodeGedung) {
                        fetchLantai(kodeGedung);
                    } else {
                        resetDropdown('lantai');
                        resetDropdown('unit');
                    }
                }
            );
        }

        if (choicesInstances.lantai) {
            choicesInstances.lantai.passedElement.element.addEventListener(
                'change',
                function(event) {
                    const lantai = event.target.value;
                    const kodeGedung = document.getElementById('kode_gedung').value;
                    if (lantai && kodeGedung) {
                        fetchUnit(kodeGedung, lantai);
                    } else {
                        resetDropdown('unit');
                    }
                }
            );
        }
    }

    function fetchLantai(kodeGedung) {
        $.ajax({
            url: '{{URL('/get-lantai')}}',
            method: 'GET',
            data: { kode_gedung: kodeGedung },
            success: function(response) {
                const options = response.map(item => ({
                    value: item.lantai,
                    label: `Lantai ${item.lantai}`
                }));
                updateChoicesDropdown('lantai', options);
                resetDropdown('unit');
            },
            error: function(xhr) {
                console.error('Error loading lantai:', xhr);
                toastr.error('Gagal memuat data lantai');
            }
        });
    }

    function fetchUnit(kodeGedung, lantai) {
        $.ajax({
            url: '{{URL('/get-units')}}',
            method: 'GET',
            data: { 
                kode_gedung: kodeGedung,
                lantai: lantai 
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                const options = response.map(item => ({
                    value: item.nama_unit,
                    label: item.nama_unit
                }));
                updateChoicesDropdown('unit', options);
            },
            error: function(xhr) {
                console.error('Error loading units:', xhr);
                toastr.error('Gagal memuat data unit');
            }
        });
    }

    function updateChoicesDropdown(field, options) {
        if (choicesInstances[field]) {
            choicesInstances[field].destroy();
        }

        const element = document.getElementById(field);
        if (element) {
            element.innerHTML = '<option value="">Pilih</option>';
            options.forEach(option => {
                const optionElement = document.createElement('option');
                optionElement.value = option.value;
                optionElement.textContent = option.label;
                element.appendChild(optionElement);
            });

            choicesInstances[field] = new Choices(element, {
                searchEnabled: true,
                itemSelectText: '',
                removeItemButton: true,
                shouldSort: false,
                classNames: {
                    containerInner: 'form-select'
                }
            });
        }
    }

    function resetDropdown(field) {
        if (choicesInstances[field]) {
            choicesInstances[field].destroy();
        }

        const element = document.getElementById(field);
        if (element) {
            element.innerHTML = '<option value="">Pilih</option>';
            choicesInstances[field] = new Choices(element, {
                searchEnabled: true,
                itemSelectText: '',
                removeItemButton: true,
                shouldSort: false,
                classNames: {
                    containerInner: 'form-select'
                }
            });
        }
    }

    function loadUnits(kodeGedung, lantai, selectedUnit = null) {
        $.ajax({
            url: "{{URL('/api/get-units')}}",
            method: 'GET',
            data: { kode_gedung: kodeGedung, lantai: lantai },
            success: function(response) {
                if (Array.isArray(response) && response.length > 0) {
                    const options = response.map(item => 
                        `<option value="${item.nama_unit}">${item.nama_unit}</option>`
                    );
                    $('#unit').html('<option value="">Pilih Unit</option>' + options.join(''));
                    
                    if (choicesInstances.unit) {
                        choicesInstances.unit.destroy();
                    }
                    choicesInstances.unit = new Choices('#unit', {
                        searchEnabled: true,
                        itemSelectText: '',
                        removeItemButton: false,
                        shouldSort: false,
                    });
                    
                    if (selectedUnit) {
                        setChoicesValue('unit', selectedUnit);
                    }
                }
            },
            error: function(xhr) {
                console.error('Error loading units:', xhr);
                toastr.error('Gagal memuat data unit');
            }
        });
    }

    // Handle edit mode
    function setChoicesValue(field, value) {
        if (choicesInstances[field] && value) {
            try {
                choicesInstances[field].setChoiceByValue(value);
            } catch (error) {
                console.warn(`Could not set value for ${field}:`, error);
            }
        }
    }

    function formatDate(dateString) {
        if (!dateString) return '';
        const date = new Date(dateString);
        return date.toISOString().split('T')[0];
    }

    function resetForm() {
        $('#asetForm')[0].reset();
        $('#aset_id').val('');
        $('#form_type').val('add');
        $('#modalTitle').text('Tambah Data Aset');
        $('#asetForm').removeClass('was-validated');
        
        choicesFields.forEach(field => {
            if (choicesInstances[field]) {
                choicesInstances[field].destroy();
            }
        });
        initializeChoices();
        
        $('#unit').html('<option value="">Pilih Unit</option>');
        if (choicesInstances.unit) {
            choicesInstances.unit.destroy();
            choicesInstances.unit = new Choices('#unit', {
                searchEnabled: true,
                itemSelectText: '',
                removeItemButton: false,
                shouldSort: false,
            });
        }

        formChanged = false;
        initialFormData = $('#asetForm').serialize();
    }

    // Button Handlers
    $('.btn-add').on('click', function() {
        resetForm();
        $('#formModal').modal('show');
    });

    $(document).on('click', '.edit-button', function() {
        const data = $(this).data('item');
        try {
            $('#form_type').val('edit');
            $('#aset_id').val(data.id);
            $('#modalTitle').text('Edit Data Aset');

            initializeChoices();

            $('#no_serial').val(data.no_serial);
            $('#fungsi_barang').val(data.fungsi_barang);
            $('#ruang').val(data.ruang);
            $('#masahidup').val(data.masahidup);
            $('#penghapusan').val(formatDate(data.penghapusan));
            $('#perbaikan').val(formatDate(data.perbaikan));
            $('#perbaikanke').val(data.perbaikanke);

            setTimeout(() => {
                setChoicesValue('nama_barang', data.nama_barang);
                setChoicesValue('unit_mitra', data.unit_mitra);
                setChoicesValue('kode_gedung', data.kode_gedung);
                setChoicesValue('lantai', data.lantai);
                setChoicesValue('semester', data.semester);
                setChoicesValue('tahun', data.tahun.toString());
                setChoicesValue('satuan', data.satuan);
                setChoicesValue('status', data.status.toString());

                if (data.kode_gedung && data.lantai) {
                    loadUnits(data.kode_gedung, data.lantai, data.unit);
                }
            }, 100);

            initialFormData = $('#asetForm').serialize();
            formChanged = false;

            $('#formModal').modal('show');
        } catch (error) {
            console.error('Error in edit button handler:', error);
            toastr.error('Terjadi kesalahan saat memuat data');
        }
    });

    $('#btnSave').on('click', function() {
        const form = $('#asetForm')[0];
        if (!form.checkValidity()) {
            form.classList.add('was-validated');
            return;
        }

        const formData = new FormData(form);
        const isEdit = $('#form_type').val() === 'edit';
        const url = isEdit ? '{{URL('/aset/update')}}' : '{{URL('/aset/store')}}';

        if (isEdit) {
            formData.append('_method', 'PUT');
        }

        $.ajax({
            url: url,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function() {
                $('#btnSave').prop('disabled', true)
                    .html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menyimpan...');
            },
            success: function(response) {
                toastr.success(isEdit ? 'Data berhasil diupdate!' : 'Data berhasil ditambahkan!');
                setTimeout(() => {
                    location.reload();
                }, 1500);
            },
            error: function(xhr) {
                console.error('Save error:', xhr);
                const errorMessage = xhr.responseJSON?.message || 'Terjadi kesalahan pada server';
                toastr.error('Gagal menyimpan data: ' + errorMessage);
                $('#btnSave').prop('disabled', false)
                    .html('<i class="fas fa-save"></i> Simpan');
            }
        });
    });

    // Initialize on page load
    initializeChoices();
});

</script>