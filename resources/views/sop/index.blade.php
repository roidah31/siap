@extends('layouts.admin')
@section('content')
<section class="content">
<div class="row">
<div class="col-12">
<div class="box">
    <div class="box-header with-border">
      <h3 class="box-title">Data SOP</h3>
    </div>
 <!-- /.box-header -->
 <div class="box-body">
   <div class="table-responsive">
   <a class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modal-form">Tambah baru</a>   
     <table id="example5" class="table table-bordered table-striped" style="width:100%">
     <thead>
       <tr> 
            <th>Kategori</th>
            <th>File</th>
            <th>aksi</th>
        </tr>
     </thead>
     <tbody>
      @foreach($sop as $r)
       <tr>  
         <td>{{$r->kategori}}</td>
		     <td>
         @if($r->filesop)
                <div class="mb-1">
                  <strong>Filename:</strong> {{$r->original_filename}}
                </div>
                <button class="btn btn-sm btn-primary download-btn" 
                        data-id="{{ $r->id }}">
                    <i class="fas fa-download"></i> Download
                </button>
            @else
                <span class="text-muted">No file uploaded</span>
            @endif
         </td>
         <td>
          <button type="button" class="btn btn-info edit-button" 
            data-item='@json($r)'>Edit
          </button>
          <button type="button" class="btn btn-danger delete-button" 
                  data-id="{{$r->id}}">Delete</button>
          </td>       
       </tr>
      @endforeach      
     </tbody>
     <tfoot>
       <tr>         
        
          <th>Kategori</th>
		      <th>File</th>
          <th>Aksi</th>        
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

@include('sop.modal')

<script>
$(document).ready(function() {
    $('.download-btn').on('click', function() {
        const fileId = $(this).data('id');
        const btn = $(this);
        
        // Disable button during request
        btn.prop('disabled', true);
        
        // Get secure download URL
        $.ajax({
            url: '/sop/get-download-url/' + fileId,
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    // Create temporary anchor and trigger download
                    const link = document.createElement('a');
                    link.href = response.download_url;
                    link.setAttribute('download', '');
                    link.click();
                    document.body.removeChild(linnk);

                    setTimeout(function(){
                      btn.prop('disabled',false);
                    },1000)
                } else {
                    alert('Error generating download link');
                    btn.prop('disabled', false);
                }
            },
            error: function() {
                alert('Error generating download link');
            },
            complete: function() {
                btn.prop('disabled', false);
            }
        });
    });
});
</script>
@endsection
