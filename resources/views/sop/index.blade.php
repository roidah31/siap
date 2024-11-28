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
    // Toastr configuration
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "timeOut": "5000",
        "extendedTimeOut": "2000"
    };

    // Handle download button clicks
    $(document).on('click', '.download-btn', function() {
        const btn = $(this);
        const fileId = btn.data('id');
        
        // Prevent double-clicks
        if (btn.prop('disabled')) return;
        
        // Show loading state
        btn.prop('disabled', true)
           .html('<i class="fas fa-spinner fa-spin"></i> Processing...');
        
        // Request download URL
        $.ajax({
            url: `{{URL('/sop/get-download-url')}}/${fileId}`,
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success && response.download_url) {
                    // Start download
                    window.location.href = response.download_url;
                    toastr.success('File sedang didownload', 'Success');
                } else {
                    toastr.error(response.message || 'Gagal mengunduh file', 'Error');
                }
            },
            error: function(xhr) {
                const errorMsg = xhr.responseJSON?.message || 'Terjadi kesalahan saat download';
                toastr.error(errorMsg, 'Error');
                console.error('Download error:', xhr);
            },
            complete: function() {
                // Reset button after delay
                setTimeout(() => {
                    btn.prop('disabled', false)
                       .html('<i class="fas fa-download"></i> Download');
                }, 1000);
            }
        });
    });
});
</script>
@endsection
