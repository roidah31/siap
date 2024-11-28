@extends('layouts.admin')
@section('content')
<div class="col-lg-6 col-12">
					<!-- Basic Forms -->
					  <div class="box">
						<div class="box-header with-border">
						  <h4 class="box-title">Form Sections</h4>
						</div>
						<!-- /.box-header -->
						<form action="{{URL('sop/store')}}" method="post" enctype="multipart/form-data">
							@csrf()
							@method('post')
							<div class="box-body">
								<h4 class="mt-0 mb-20">Customer Info:</h4>
								<div class="form-group">
									<label class="form-label">Kode gedung:</label>
									<input type="text" class="form-control" name="kategori" id="kategori">
								</div>
								<div class="form-group">
									<label class="form-label">Image:</label>							
									<input type="file" class="form-control" name="filesop" id="filesop">
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
@endsection