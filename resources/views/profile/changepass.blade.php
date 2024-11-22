@extends('layouts.admin')
@section('content')
<section class="content">
<div class="row">
    <div class="col-12 col-lg-7 col-xl-8">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li><a class="active" href="#password" data-bs-toggle="tab">Change Password</a></li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane active" id="password">     
                    <div class="box no-shadow">     
                        <form class="form-horizontal form-element col-12" method="POST" action="{{ route('profile.password.update') }}">
                            @csrf
                            @method('PUT')
                            
                            @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if(session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif

                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="form-group row">
                                <label for="current_password" class="col-sm-2 form-label">Current Password</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" id="current_password" name="current_password" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="new_password" class="col-sm-2 form-label">New Password</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" id="new_password" name="new_password" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="new_password_confirmation" class="col-sm-2 form-label">Confirm New Password</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="ms-auto col-sm-10">
                                    <button type="submit" class="btn btn-success">Update Password</button>
                                </div>
                            </div>
                        </form>
                    </div>          
                </div>
            </div>
        </div>
    </div>

    <!-- Right side column -->
    <div class="col-12 col-lg-5 col-xl-4">
        <div class="box box-widget widget-user">
            <div class="widget-user-header bg-img bbsr-0 bber-0" style="background: url('{{asset('assets/images/svg-icon/color-svg/custom-1.svg')}}') center center;" data-overlay="6">
                <h3 class="widget-user-username text-white">{{ auth()->user()->name }}</h3>
                <h6 class="widget-user-desc text-white">{{ auth()->user()->namaunit }}</h6>
            </div>
            <div class="box-footer">
                <div class="row">
                    <div class="col-12">
                        <div>
                            <p>Tip Keamanan Kata Sandi:</p>
                            <ul class="text-gray ps-10">
                                <li>Gunakan minimal 8 karakter</li>
                                <li>Sertakan huruf besar dan kecil</li>
                                <li>Sertakan angka dan karakter khusus</li>
                                <li>Hindari menggunakan informasi pribadi</li>    
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
@endsection
