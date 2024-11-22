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
						<form action="{{URL('/barangubah')}}" method="POST">
							@csrf()
							<div class="box-body">								
								<div class="form-group">
									@csrf()
									<label class="form-label">Nama barang:</label>
									<input type="text" id="id" name="id" value="{{$brg->id}}" class="form-control" placeholder="Enter full name">
									<input type="text" id="namabarang" name="nama_barang" value="{{$brg->namabarang}}" class="form-control" placeholder="Enter full name">
								</div>								
							</div>
							<!-- /.box-body -->
							<div class="box-footer">
								<button type="submit" class="btn btn-danger">Cancel</button>
								<button type="submit" class="btn btn-success pull-right">Submit</button>
							</div>
						</form>
					  </div>
					  <!-- /.box -->			
				</div>
</div>
</div>
</section>
@endsection