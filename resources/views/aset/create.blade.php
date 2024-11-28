@extends('layouts.admin')
@section('content')
<section class="content">
    <div class="row">
        <div class="col-lg-12">
					  <div class="box">
						<div class="box-header with-border">
						  <h4 class="box-title">Pengisian Form Aset</h4>
						</div>
						<!-- /.box-header -->
						<form class="form" id="add-gedung-form" action="{{Route('gedung.store')}}" method="POST" enctype="multipart/form-data" novalidate>
							<div class="box-body">
								<h4 class="box-title text-info mb-0"><i class="ti-user me-15"></i> About User</h4>
								<hr class="my-15">
								<div class="row">
								  <div class="col-md-6">

									<div class="form-group">
                                    <label for="add_kode_gedung" class="form-label">
                                            Kode Gedung <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                                class="form-control" 
                                                id="add_kode_gedung" 
                                                name="kode_gedung" 
                                                placeholder="Masukkan kode gedung"
                                                required 
                                                autocomplete="off">
                                        <div class="invalid-feedback"> Kode gedung harus diisi</div>
									</div>
								  </div>
								  <div class="col-md-6">
									<div class="form-group">
                                    <label for="add_nama_gedung" class="form-label">
                                        Nama Gedung <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                                class="form-control" 
                                                id="add_nama_gedung" 
                                                name="nama_gedung" 
                                                placeholder="Masukkan nama gedung"
                                                required 
                                                autocomplete="off">
                                        <div class="invalid-feedback">
                                            Nama gedung harus diisi
                                        </div>
									</div>
								  </div>
								</div>
								<div class="row">
								  <div class="col-md-6">
									<div class="form-group">
                                        <label for="add_imagegedung" class="form-label">
                File Image <span class="text-danger file-required">*</span>
                </label>
                                        <input type="file" 
                                            class="form-control" 
                                            id="add_imagegedung" 
                                            name="imagegedung" 
                                            accept="image/*"
                                            required>
                                            <div class="invalid-feedback">
                                                File image harus diupload
                                            </div>
									</div>
								  </div>
								  <div class="col-md-6">
									<div class="form-group">
									  <label class="form-label">Contact Number</label>
									  <input type="text" class="form-control" placeholder="Phone">
									</div>
								  </div>
								</div>
								<h4 class="box-title text-info mb-0 mt-20"><i class="ti-envelope me-15"></i> Contact Info & Bio</h4>
								<hr class="my-15">
								<div class="form-group">
								  <label class="form-label">Email</label>
								  <input class="form-control" type="email" placeholder="email">
								</div>
								<div class="form-group">
								  <label class="form-label">Website</label>
								  <input class="form-control" type="url" placeholder="http://">
								</div>
								<div class="form-group">
								  <label class="form-label">Contact Number</label>
								  <input class="form-control" type="tel" placeholder="Contact Number">
								</div>
								<div class="form-group">
								  <label class="form-label">Bio</label>
								  <textarea rows="4" class="form-control" placeholder="Bio"></textarea>
								</div>
							</div>
							<!-- /.box-body -->
							<div class="box-footer text-end">
								<button type="button" class="btn btn-warning me-1">
								  <i class="ti-trash"></i> Cancel
								</button>
								<button type="submit" class="btn btn-primary">
								  <i class="ti-save-alt"></i> Save
								</button>
							</div>  
						</form>
					  </div>
					  <!-- /.box -->			
		</div>
    </div>
</section>
@endsection