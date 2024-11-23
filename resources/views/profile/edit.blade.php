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
                            <!-- {{-- Success Message --}}
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
                            @endif -->
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
                            <div class="form-group">
                                <label for="kodeunit">Kode Unit</label>
                                <select name="kodeunit" id="kodeunit" class="form-control" required>
                                    <option value="">Pilih Kode Unit</option>
                                    @foreach ($unitArr as $unit)
                                        <option value="{{ $unit->kodeunit }}" {{ $user->kodeunit == $unit->kodeunit ? 'selected' : '' }}>
                                            {{ $unit->kodeunit }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group row mb-3">
                                <label for="namaunit" class="col-sm-2 form-label">Nama Unit</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control @error('namaunit') is-invalid @enderror" 
                                        id="namaunit" name="namaunit" required value="{{ old('namaunit', auth()->user()->namaunit) }}">
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>


<script>
     toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "timeOut": "3000"
    };
    
    document.getElementById('kodeunit').addEventListener('change', function() {
    var kodeunit = this.value;

    // Mengambil namaunit berdasarkan kodeunit
    if (kodeunit) {
        // Memanggil API untuk mendapatkan namaunit berdasarkan kodeunit yang dipilih
        fetch(`{{ url('/api/get-nama-unit') }}/${kodeunit}`)
            .then(response => response.json())
            .then(data => {
                var namaunitInput = document.getElementById('namaunit');
                
                // Reset nilai input namaunit
                namaunitInput.value = ''; // Resetkan inputan

                // Periksa apakah data yang diterima ada dan namaunitnya ada
                if (data && data.namaunit) {
                    // Isi input dengan namaunit yang diterima
                    namaunitInput.value = data.namaunit;
                } else {
                    // Jika namaunit tidak ditemukan, beri pesan atau kosongkan input
                    namaunitInput.value = "Nama Unit tidak ditemukan";
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Menangani error jika fetch gagal
                var namaunitInput = document.getElementById('namaunit');
                namaunitInput.value = "Terjadi kesalahan, coba lagi.";
            });
    }
});

// Mengisi namaunit saat halaman pertama kali dimuat jika kodeunit sudah terpilih
document.addEventListener('DOMContentLoaded', function() {
    toastr.success('Profile updated successfully!', 'Success');
    
    var kodeunit = document.getElementById('kodeunit').value;
    if (kodeunit) {
        fetch(`{{ url('/api/get-nama-unit') }}/${kodeunit}`)
            .then(response => response.json())
            .then(data => {
                var namaunitInput = document.getElementById('namaunit');
                if (data && data.namaunit) {
                    namaunitInput.value = data.namaunit;
                }
            })
            .catch(error => console.error('Error:', error));
    }
});


</script>


</section>
@endsection
