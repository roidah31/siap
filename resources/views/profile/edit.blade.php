@extends('layouts.admin')
@section('content')
@push('css')
<link href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" rel="stylesheet">
@endpush
<section class="content">
<div class="row">
    <div class="col-12 col-lg-7 col-xl-8">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li><a class="active" href="#settings" data-bs-toggle="tab">Ubah Profil</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="settings">     
                    <div class="box no-shadow">     
                        <form class="form-horizontal form-element col-12" method="POST" action="{{ URL('/profile/update') }}" id="profileForm">
                            @csrf
                            @method('POST')
                            
                            {{-- Success Message --}}
                            @if(session('success') || session('status') === 'profile-updated')
                                <div class="alert alert-success alert-dismissible fade show">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    {{ session('success') ?: 'Profile updated successfully!' }}
                                </div>
                            @endif

                            {{-- Error Messages --}}
                            @if($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="form-group row mb-3">
                                <label for="name" class="col-sm-2 form-label">Name</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name', auth()->user()->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label for="email" class="col-sm-2 form-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email" value="{{ old('email', auth()->user()->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label for="username" class="col-sm-2 form-label">Username</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control @error('username') is-invalid @enderror" 
                                           id="username" name="username" value="{{ old('username', auth()->user()->username) }}" required>
                                    @error('username')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                            <label for="kodeunit" class="col-sm-2 form-label">Kode Unit</label>
                            <div class="col-sm-10">
                                <select class="form-select @error('kodeunit') is-invalid @enderror" 
                                        id="kodeunit" name="kodeunit" required>
                                    <option value="">Pilih Kode Unit</option>
                                    @foreach($units as $unit)
                                        <option value="{{ $unit->kodeunit }}" 
                                                data-namaunit="{{ $unit->namaunit }}"
                                                {{ old('kodeunit', auth()->user()->kodeunit) == $unit->kodeunit ? 'selected' : '' }}>
                                            {{ $unit->kodeunit }} 
                                        </option>
                                    @endforeach
                                </select>
                                @error('kodeunit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="namaunit" class="col-sm-2 form-label">Nama Unit</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control @error('namaunit') is-invalid @enderror" 
                                    id="namaunit" name="namaunit"  required
                                    value="{{ old('namaunit', auth()->user()->namaunit) }}">
                                @error('namaunit')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                            <div class="form-group row">
                                <div class="ms-auto col-sm-10">
                                    <button type="submit" class="btn btn-success">Update Profile</button>
                                </div>
                            </div>
                        </form>
                    </div>          
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-5 col-xl-4">
        <div class="box box-widget widget-user">
            <div class="box-body d-flex p-0">
                <div class="flex-grow-1 bg-primary p-30 flex-grow-1 bg-img" 
                     style="background-position: calc(100% + 0.5rem) bottom; background-size: auto 100%; 
                            background-image: url({{asset('assets/images/svg-icon/color-svg/custom-5.svg')}})">
                    <h4 class="fw-400">Detail</h4>
                    <div class="mt-5">
                        <div class="table-responsive">
                            <table class="table table-borderless mb-0 text-white">
                                <tbody>
                                    <tr>
                                        <th scope="col">Username</th>
                                        <th scope="col">:</th>
                                        <th scope="col">{{ auth()->user()->username }}</th>
                                    </tr>
                                    <tr>
                                        <th scope="col">Email</th>
                                        <th scope="col">:</th>
                                        <th scope="col">{{ auth()->user()->email }}</th>
                                    </tr>
                                    <tr>
                                        <th scope="col">Unit</th>
                                        <th scope="col">:</th>
                                        <th scope="col">{{ auth()->user()->namaunit }}</th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
<script>
     toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "timeOut": "3000"
    };
    document.addEventListener('DOMContentLoaded', function() {
    
    // Initialize Choices.js
    const kodeunitSelect = new Choices('#kodeunit', {
        searchEnabled: true,
        removeItemButton: false,
        placeholder: true,
        placeholderValue: 'Pilih Kode Unit'
    });

    // Event listener untuk perubahan kodeunit
    document.getElementById('kodeunit').addEventListener('change', function(event) {
        handleKodeUnitChange(event.target.value, '#namaunit');
    });

    // Function untuk handle perubahan kodeunit
    function handleKodeUnitChange(kodeUnit, targetInput) {
        if (!kodeUnit) {
            $(targetInput).val('');
            return;
        }

        $.ajax({
            url: '/api/get-nama-unit',
            method: 'GET',
            data: { kode_unit: kodeUnit },
            success: function(response) {
                $(targetInput).val(response.nama_unit || '');
            },
            error: function() {
                toastr.error('Gagal mengambil data nama unit');
                $(targetInput).val('');
            }
        });
    }

    // Set initial value jika ada
    const initialKodeUnit = '{{ old('kodeunit', auth()->user()->kodeunit) }}';
    if (initialKodeUnit) {
        kodeunitSelect.setChoiceByValue(initialKodeUnit);
        handleKodeUnitChange(initialKodeUnit, '#namaunit');
    }

    // Form submission
    const form = document.getElementById('profileForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            const kodeunit = document.getElementById('kodeunit').value;
            const namaunit = document.getElementById('namaunit').value;
            
            if (!kodeunit || !namaunit) {
                e.preventDefault();
                toastr.error('Silakan pilih Kode Unit');
                return;
            }

            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Updating...';
            }
        });
    }
});

function fetchkodeunit() {
    $.ajax({
        url: '/api/get-nama-unit',
        method: 'GET',
        success: function (response) {
            if (response && Array.isArray(response)) {
                const choices = response.map(item => ({
                    value: item.kodeunit,
                    label: item.kodeunit
                }));

                editChoices.clearChoices();
                editChoices.setChoices(choices);
            }
        },
        error: function (xhr, status, error) {
            toastr.error('Gagal mengambil data kode gedung');
            console.error('Error fetching kode gedung:', error);
        }
        });
    }

    fetchkodeunit();
 // Event listener for kodeunit change
 document.getElementById('kodeunit').addEventListener('change', function(event) {
        handlekodeunitChange(event.target.value, '#namaunit');
    });

    document.getElementById('kodeunit').addEventListener('change', function(event) {
    const kodeunit = event.target.value;
    if (kodeunit) {
        $.ajax({
            url: '/api/get-nama-unit',
            method: 'GET',
            data: { kodeunit: kodeunit },
            success: function (response) {
                $('#namaunit').val(response.namaunit || '');
            },
            error: function () {
                toastr.error('Gagal mengambil data nama gedung');
                $('#namaunit').val('');
            }
        });
        } else {
            $('#namaunit').val('');
        }
    });

    function handlekodeunitChange(kodeunit, targetInput) {
        if (!kodeunit) {
            $(targetInput).val('');
        return;
        }  $.ajax({
                url: '/api/get-nama-unit',
                method: 'GET',
                data: { kode_gedung: kodeunit },
                success: function (response) {
                    $(targetInput).val(response.nama_gedung || '');
                },
                error: function () {
                    toastr.error('Gagal mengambil data nama gedung');
                    $(targetInput).val('');
                }
            });
    }
</script>
@endpush

</section>
@endsection
