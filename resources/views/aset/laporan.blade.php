@extends('layouts.admin')
@section('content')


<section class="content">
<div class="row">
<div class="col-12">

<div class="box">
 <div class="box-header with-border">
   <h3 class="box-title">Data Aset</h3>
 </div>
 <div class="box-body">
   <div class="table-responsive">
    <!-- Form Filter Search -->
        <div style="width: 100%; display: table;">
            <div style="display: table-row">
                    <form class="user" action="{{ URL('aset/laporan') }}" method="POST" novalidate>
                            @csrf()
                            <div class="modal-body" style="display: table-cell;">
                                <div class="form-group">
                                    <h6 style="font-size:12px">NAMA BARANG :</h6>
                                    <select class="form-control select2" id="nama_barang" name="nama_barang">
                                        <option value=""></option>
                                        @foreach($brg as $barang)
                                            <option value="{{ $barang->namabarang }}" 
                                                {{ old('nama_barang') == $barang->namabarang ? 'selected' : '' }}>
                                                {{ $barang->namabarang }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" 
                                           id="no_serial" name="no_serial" 
                                           value="{{ old('no_serial') }}"
                                           placeholder="Serial Number">
                                </div>
                                <h6 style="font-size:12px">LOKASI :</h6>
                                <div class="form-group">
                                    <select class="form-control select2" id="kode_gedung" name="kode_gedung">
                                        <option value=""></option>
                                        @foreach($gedung as $g)
                                            <option value="{{ $g->kode_gedung }}" 
                                                {{ old('kode_gedung') == $g->kode_gedung ? 'selected' : '' }}>
                                                {{ $g->kode_gedung }} - {{ $g->nama_gedung }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select id="lantai" class="form-control" name="lantai" required>
                                        <option value="">Pilih Lantai</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <select id="unit" class="form-control" name="unit" required>
                                        <option value="">Pilih Unit</option>
                                    </select>
                                </div>
                                                               
                            </div>
                            <div class="modal-body" style="display: table-cell;">
                                <h6 style="font-size:12px">WAKTU PENGADAAN BARANG</h6>
                                <div class="form-group">
                                    <select class="form-control" id="semester" name="semester">
                                        <option value=""></option>
                                        <option value="ganjil" {{ old('semester') == 'ganjil' ? 'selected' : '' }}>GANJIL</option>
                                        <option value="genap" {{ old('semester') == 'genap' ? 'selected' : '' }}>GENAP</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <select name="tahun" id="tahun" class="form-control">
                                        <option value=""></option>
                                        @for($i = date('Y'); $i >= date('Y')-32; $i--)
                                            <option value="{{ $i }}" {{ old('tahun') == $i ? 'selected' : '' }}>
                                                {{ $i }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="modal-body" style="display: table-cell;">
                                <h6 style="font-size:12px">MASA HIDUP :</h6>
                                <div class="form-group">
                                    <select name="satuan" id="satuan" class="form-control">
                                        <option value="">PILIH BULAN ATAU TAHUN</option>
                                        <option value="Tahun" {{ old('satuan') == 'Tahun' ? 'selected' : '' }}>Tahun</option>
                                        <option value="Bulan" {{ old('satuan') == 'Bulan' ? 'selected' : '' }}>Bulan</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <input type="number" name="masahidup" id="masahidup" 
                                           class="form-control" 
                                           value="{{ old('masahidup') }}"
                                           placeholder="Angka Masa Hidup">
                                </div>
                            </div>
                            <div class="modal-body" style="display: table-cell;">
                                <h6 style="font-size:12px">PENGHAPUSAN :</h6>
                                <div class="form-group">
                                    <input type="date" class="form-control form-control-user" 
                                           id="penghapusan" name="penghapusan"
                                           value="{{ old('penghapusan') }}">
                                </div>
                                <h6 style="font-size:12px">PERBAIKAN</h6>
                                <div class="form-group">
                                    <input type="date" class="form-control form-control-user" 
                                           id="perbaikan" name="perbaikan"
                                           value="{{ old('perbaikan') }}">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success btn-user btn-block">
                                    FILTER
                                </button>
                                <button type="submit" id="hapusFilter" class="btn btn-danger btn-user btn-block" 
                                       >
                                    HAPUS FILTER
                                </button>
                                <button type="reset" class="btn btn-warning btn-user btn-block" onClick="window.location.href=window.location.href;">
                                    RESET
                                </button>
                                <!-- @if(auth()->user()->role_id == 1 || auth()->user()->role_id == 5)
                                    <a href="{{ route('aset.export.pdf') }}" class="btn btn-danger btn-user btn-block">
                                        PRINT ALL ASET
                                    </a>
                                @endif -->
                            </div>

                    </form>
            </div>
        </div>
     <!-- <table id="example5" class="table table-bordered table-striped" style="width:100%"> -->
     <table id="example" class="table table-bordered table-hover display nowrap margin-top-10 w-p100">
     <thead>
        <tr>
          <th>No serial </th>
          <th>Nama Barang</th>
          <th>Fungsi Barang</th>
          <th>Unit</th>
          <th>Lantai</th>
          <th>Ruang</th>
          <th>Semester</th>
          <th>Tahun</th>
          <th>Status</th>
          <th>Nama Penginput</th>
          <th>Unit Penginput</th>
          <th>Masa Hidup</th>
          <th>Penghapusan</th>
          <th>Perbaikan</th>
          <th>Perbaikan ke</th>
    
        </tr>
     </thead>
     <tbody>
      @foreach($aset as $r)
       <tr>    
          <td>{{$r->no_serial}}</td>
          <td>{{$r->nama_barang}}</td>
          <td>{{$r->fungsi_barang}}</td>
          <td>{{$r->unit}}</td>
          <td>{{$r->lantai}}</td>
          <td>{{$r->ruang}}</td>
          <td>{{$r->semester}}</td>
          <td>{{$r->tahun}}</td>
          <td>
            @if($r->status == 0)
              BAIK
            @elseif($r->status == 1) 
              RUSAK RINGAN
            @elseif($r->status == 2)
              RUSAK BERAT
            @else
              HILANG
            @endif
          </td>
          <td>{{$r->namapenginput}}</td>
          <td>{{$r->kdunitpenginput}}</td>
          <td>{{$r->masahidup}} {{$r->satuan}}</td>   
          <td>{{$r->penghapusan }}</td>
          <td>{{$r->perbaikan}}</td>         
          <td>{{ $r->perbaikanke}}</td>
               
       </tr>
      @endforeach
     </tbody>
   </table>
   </div>
 </div>
</div>
</div> 
</div>
</section>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css"/>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>

<script>
$(document).ready(function () {
    let choicesInstances = {};
    let formChanged = false;
    let initialFormData = '';
    
    // Fields yang menggunakan Choices.js
    const choicesFields = [
        'nama_barang',
        'unit_mitra',
        'kode_gedung',
        'lantai',
        'unit',
        'semester',
        'tahun',
        'satuan',
        'status'
    ];

    // Initialize Choices.js untuk semua fields
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
        // Event listener untuk gedung
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

        // Event listener untuk lantai
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

    // set Lantai
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
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Gagal memuat data lantai'
                });
            }
        });
    }

    //set unit
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
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Gagal memuat data unit'
                });
            }
        });
    }

    function updateChoicesDropdown(field, options) {
        if (choicesInstances[field]) {
            choicesInstances[field].destroy();
        }

        const element = document.getElementById(field);
        if (element) {
            // Clear existing options
            element.innerHTML = '<option value="">Pilih</option>';
            
            // Add new options
            options.forEach(option => {
                const optionElement = document.createElement('option');
                optionElement.value = option.value;
                optionElement.textContent = option.label;
                element.appendChild(optionElement);
            });

            // Reinitialize Choices.js
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

     // Reset dropdown ke state awal
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


    // Handle edit mode dengan Choices.js
    function handleEditMode(data) {
        if (data.kode_gedung) {
            // Set gedung value
            setChoicesValue('kode_gedung', data.kode_gedung);
            
            // Fetch and set lantai
            fetchLantai(data.kode_gedung);
            
            // Set lantai value after a small delay to ensure options are loaded
            setTimeout(() => {
                if (data.lantai) {
                    setChoicesValue('lantai', data.lantai);
                    
                    // Fetch and set unit
                    fetchUnit(data.kode_gedung, data.lantai);
                    
                    // Set unit value after another small delay
                    setTimeout(() => {
                        if (data.unit) {
                            setChoicesValue('unit', data.unit);
                        }
                    }, 300);
                }
            }, 300);
        }
    }

    // Function untuk set nilai Choices.js
    function setChoicesValue(field, value) {
        if (choicesInstances[field] && value) {
            try {
                choicesInstances[field].setChoiceByValue(value);
            } catch (error) {
                console.warn(`Could not set value for ${field}:`, error);
            }
        }
    }

    // Function untuk format tanggal
    function formatDate(dateString) {
        if (!dateString) return '';
        const date = new Date(dateString);
        return date.toISOString().split('T')[0];
    }

    // Function untuk cek perubahan form
    function hasFormChanged() {
        const currentFormData = $('#asetForm').serialize();
        return currentFormData !== initialFormData;
    }

    // Function untuk reset form
    function resetForm() {
        $('#asetForm')[0].reset();
        $('#aset_id').val('');
        $('#form_type').val('add');
        $('#modalTitle').text('Tambah Data Aset');
        $('#asetForm').removeClass('was-validated');
        
        // Reset semua Choices.js instances
        choicesFields.forEach(field => {
            if (choicesInstances[field]) {
                choicesInstances[field].destroy();
            }
        });
        initializeChoices();
        
        // Clear unit dropdown
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

    // Function untuk load units berdasarkan gedung dan lantai
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
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Gagal memuat data unit'
                });
            }
        });
    }

    // Handle Add Button Click
    $('.btn-add').on('click', function() {
        resetForm();
        $('#formModal').modal('show');
    });

    // Handle Edit Button Click
    $(document).on('click', '.edit-button', function() {
        try {
            const data = $(this).data('item');
            
            // Reset form terlebih dahulu
            $('#asetForm')[0].reset();
            
            // Set form type dan ID
            $('#form_type').val('edit');
            $('#aset_id').val(data.id);
            $('#modalTitle').text('Edit Data Aset');

            // Initialize Choices.js
            initializeChoices();

            // Set values untuk regular inputs
            $('#no_serial').val(data.no_serial);
            $('#fungsi_barang').val(data.fungsi_barang);
            $('#ruang').val(data.ruang);
            $('#masahidup').val(data.masahidup);
            $('#penghapusan').val(formatDate(data.penghapusan));
            $('#perbaikan').val(formatDate(data.perbaikan));
            $('#perbaikanke').val(data.perbaikanke);

            // Set values untuk select options dengan delay kecil
            setTimeout(() => {
                setChoicesValue('nama_barang', data.nama_barang);
                setChoicesValue('unit_mitra', data.unit_mitra);
                setChoicesValue('kode_gedung', data.kode_gedung);
                setChoicesValue('lantai', data.lantai);
                setChoicesValue('semester', data.semester);
                setChoicesValue('tahun', data.tahun.toString());
                setChoicesValue('satuan', data.satuan);
                setChoicesValue('status', data.status.toString());

                // Load units setelah gedung dan lantai di-set
                if (data.kode_gedung && data.lantai) {
                    loadUnits(data.kode_gedung, data.lantai, data.unit);
                }
            }, 100);

            // Simpan state awal form setelah semua nilai di-set
            initialFormData = $('#asetForm').serialize();
            formChanged = false;

            $('#formModal').modal('show');
        } catch (error) {
            console.error('Error in edit button handler:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Terjadi kesalahan saat memuat data'
            });
        }
    });

    // Handle Save Button Click
    $('#btnSave').on('click', function() {
        const form = $('#asetForm')[0];
        if (!form.checkValidity()) {
            form.classList.add('was-validated');
            return;
        }

        const formData = new FormData(form);
        const isEdit = $('#form_type').val() === 'edit';
        const url = isEdit ? '{{URL('/aset/update')}}' : '/aset/store';

        // Tambahkan method PUT untuk edit
        if (isEdit) {
            formData.append('_method', 'PUT');
        }

        Swal.fire({
            title: 'Konfirmasi',
            text: isEdit ? 'Apakah Anda yakin ingin mengupdate data ini?' : 'Apakah Anda yakin ingin menyimpan data ini?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Simpan',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    method: 'POST', // Tetap POST karena kita menggunakan FormData dengan _method
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $('#btnSave').prop('disabled', true)
                            .html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menyimpan...');
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: isEdit ? 'Data berhasil diupdate!' : 'Data berhasil ditambahkan!'
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function(xhr) {
                        console.error('Save error:', xhr);
                        const errorMessage = xhr.responseJSON?.message || 'Terjadi kesalahan pada server';
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Gagal menyimpan data: ' + errorMessage
                        });
                        $('#btnSave').prop('disabled', false)
                            .html('<i class="fas fa-save"></i> Simpan');
                    }
                });
            }
        });
    });

    // Event handlers lainnya tetap sama
    // ...

    // Initialize saat halaman load
    initializeChoices();
});
</script>

@endsection
