@extends('layouts.admin')
@section('content')
<section class="content">
<div class="row">
<div class="col-12">

<div class="box">
 <div class="box-header with-border">
   <h3 class="box-title">Data Unit</h3>
 </div>
 <!-- /.box-header -->
 <div class="box-body">
   <div class="table-responsive">
	<a type="button" class="btn btn-primary  mb-3" data-bs-toggle="modal" data-bs-target="#modal-right">
		Tambah baru
	</a>
	
     <table id="example5" class="table table-bordered table-striped" style="width:100%">
     <thead>
       <tr>
         <th>Kode gedung</th>
         <th>Nama gedung</th>
         <th>Lantai</th>
         <th>Nama unit</th>
         <th>aksi</th>
       </tr>
     </thead>
     <tbody>
      @foreach($unit as $r)
       <tr>       
         <td>{{$r->kode_gedung}}</td>
         <td>{{$r->nama_gedung}}</td>
         <td>{{$r->lantai}}</td>
         <td>{{ $r->nama_unit}}</td>
         <td><button type="button" class="btn btn-info edit-button" 
                  data-item='@json($r)'>Edit</button>
            <button type="button" class="btn btn-danger delete-button" 
                    data-id="{{$r->id}}">Delete</button></td>       
       </tr>
      @endforeach
      
     </tbody>
     <tfoot>
       <tr>         
       <th>Kode gedung</th>
         <th>Nama gedung</th>
         <th>Lantai</th>
         <th>Nama unit</th>
         <th>aksi</th>       
       </tr>
     </tfoot>
   </table>
   </div>
 </div>
 <!-- /.box-body -->
 </div>
 <!-- /.box -->      
</div> 
</div>
</section>

 
  <!-- /.modal -->
   @include('unit.modal')
@endsection
