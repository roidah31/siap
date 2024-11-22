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
						<form action="{{URL('/unit/store')}}" method="POST">
							@csrf()
							<div class="mb-3">
								<label for="kode_gedung" class="form-label">Kode gedung</label>
								<input type="text"  id="kode_gedung" class="form-control" name="kode_gedung" required>
									
							</div>
							<div class="mb-3">
								<label for="nama_gedung" class="form-label">Nama Gedung</label>
								<input type="text" id="nama_gedung" class="form-control" placeholder="Nama Gedung" name="nama_gedung">
							</div>
							<div class="mb-3">
								<label for="lantai" class="form-label">Lantai</label>
								<input type="text" class="form-control" id="lantai" name="lantai" required>
							</div>
							<div class="mb-3">
								<label for="nama_unit" class="form-label">Nama Unit</label>
								<input type="text" class="form-control" id="nama_unit" name="nama_unit" required>
							</div>

							<button type="submit" value="submit">simpan</button>
						</form>
					  </div>
					  <!-- /.box -->			
				</div>
</div>
</div>
</section>
@endsection