
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Modal -->
<div class="modal modal-form fade" id="modal-form" tabindex="-1" data-bs-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-title">Tambah SOP</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="sop-form" method="post" enctype="multipart/form-data" novalidate>
          @csrf
          <input type="hidden" id="sop_id" name="id">
          <!-- Kategori -->
          <div class="mb-3">
            <label for="kategori" class="form-label">
              Kategori <span class="text-danger">*</span>
            </label>
            <div class="input-group has-validation">
              <span class="input-group-text">
                <i class="ti-home"></i>
              </span>
              <input type="text" 
                     class="form-control" 
                     id="kategori" 
                     name="kategori" 
                     placeholder="Masukkan nama gedung"
                     required 
                     autocomplete="off">
              <div class="invalid-feedback">
                Kategori harus diisi
              </div>
            </div>
          </div>

          <!-- Image Upload -->
          <div class="mb-3">
            <label for="filesop" class="form-label">
              File SOP <span class="text-danger file-required">*</span>
            </label>
            <div class="input-group has-validation">
              <span class="input-group-text">
                <i class="ti-image"></i>
              </span>
              <input type="file" 
                     class="form-control" 
                     id="filesop" 
                     name="filesop" 
					 accept=".doc,.docx,.pdf,.xls,.xlsx">
              <div class="invalid-feedback">
                File  harus diupload
              </div>
            </div>
            <div class="form-text mt-2">
              <i class="ti-info-alt me-1"></i>
              Format: DOC, PDF, DOCX, XLS (Max. 10MB)
            </div>

            <!-- Preview Container -->
            <div id="image-preview" class="mt-3 d-none">
              <div class="card">
                <div class="card-body p-2">
                  <div class="d-flex align-items-center">
                    <img src="" alt="Preview" class="img-thumbnail me-3" style="max-height: 100px;">
                    <div class="flex-grow-1">
                      <h6 class="preview-name mb-1"></h6>
                      <p class="preview-size mb-0 text-muted small"></p>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-danger" id="remove-image">
                      <i class="ti-trash"></i>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Progress Bar -->
          <div class="progress d-none mb-3">
            <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" 
                 role="progressbar" 
                 style="width: 0%" 
                 aria-valuenow="0" 
                 aria-valuemin="0" 
                 aria-valuemax="100">0%</div>
          </div>

          <!-- Upload Status -->
          <div class="alert alert-info alert-dismissible fade d-none" id="upload-status" role="alert">
            <i class="ti-info-alt me-2"></i>
            Sedang mengupload... Mohon tunggu.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			
          </div>
        </form>
      </div>
	  <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-primary" onclick="submitForm()" id="btn-save">Simpan Perubahan</button>
      </div>
      <!-- Modal Footer -->
   
    </div>
  </div>
</div>
<!-- Delete Modal -->
<div class="modal fade" id="modal-delete-sop" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Hapus Gedung</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus gedung ini?</p>
                <input type="hidden" id="delete-id" name="id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" id="confirm-delete" class="btn btn-danger">Hapus</button>
            </div>
        </div>
    </div>
</div>

<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css" rel="stylesheet">

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>

	<script>
    $(document).ready(function () {
    // Initialize Bootstrap modals
    const modalForm = new bootstrap.Modal(document.getElementById('modal-form'));
    const modalDelete = new bootstrap.Modal(document.getElementById('modal-delete-sop'));

    // Toastr configuration
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };

    let isUploading = false;
    let originalImage = '';
    // Function to reset form and variables
	window.submitForm = function() {
        if (validateForm()) {
            const formData = new FormData($('#sop-form')[0]);
            const sopId = $('#sop_id').val();
            const url = sopId ? `/sop/update` : '/sop/store';
            const hasFile = $('#filesop')[0].files.length > 0;

			//data yang di update apakah memiliki data file 
			if(sopId ){
				    formData.append('sopId', sopId); // Menambahkan ID ke formData
            formData.append('_method', 'POST');
            if(!hasFile) {
                formData.append('keep_image', 'true');
            }
			}

            $.ajax({
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
		  
                url: url,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function() {
					
                    if (hasFile) {
                        $('.progress').removeClass('d-none');
                    }
                    isUploading = true;
                    disableForm(true);
                },
                xhr: function() {
                    const xhr = new window.XMLHttpRequest();
                    if (hasFile) {
                        xhr.upload.addEventListener('progress', function(event) {
                            if (event.lengthComputable) {
                                const percentComplete = Math.round((event.loaded / event.total) * 100);
                                updateProgressBar(percentComplete);
                            }
                        }, false);
                    }
                    return xhr;
                },
                success: function(response) {
                    toastr.success(response.success || "Data berhasil disimpan");
                    $('#modal-form').modal('hide');
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                },
                error: function(xhr) {
                    const response = xhr.responseJSON || {};
                    const message = response.message || "Terjadi kesalahan";
                    const errors = response.errors || {};
                    
                    let errorMessage = message;
                    if (Object.keys(errors).length > 0) {
                        errorMessage += '\n' + Object.values(errors).flat().join('\n');
                    }
                    
                    toastr.error(errorMessage);
                    disableForm(false);
                },
                complete: function() {
                    $('.progress').addClass('d-none');
                    isUploading = false;
                    disableForm(false);
                }
            });
        }
    }

    function validateForm() {
        let isValid = true;
       
        const Kategori = $('#kategori').val().trim();
        const fileSop = $('#filesop')[0].files[0];
        const sopId = $('#sop_id').val();

        // Clear previous validation
        $('#sop-form input').removeClass('is-invalid');
        $('.invalid-feedback').hide();

      

        if (!Kategori) {
            showValidationError($('#kategori'), 'Kategori harus diisi');
            isValid = false;
        }

        if (!sopId && !fileSop && $('#filesop').prop('required')) {
            showValidationError($('#filesop'), 'File SOP harus diupload untuk data baru');
            isValid = false;
        }

        return isValid;
    }

    function showValidationError(element, message) {
        element.addClass('is-invalid');
        element.siblings('.invalid-feedback').text(message).show();
    }

    function updateProgressBar(percent) {
        $('.progress-bar')
            .css('width', percent + '%')
            .attr('aria-valuenow', percent)
            .text(percent + '%');
    }

    function disableForm(disabled) {
        $('#sop-form :input').prop('disabled', disabled);
        $('.modal-footer button').prop('disabled', disabled);
    }

    // Handle Add Button Click
    $('.btn-add').on('click', function() {
        resetForm();
        $('#modal-form').modal('show');
    });

    function showExistingImage(filePath) {
    if (filePath) {
          $('#image-preview')
              .removeClass('d-none')
              .find('img')
              .attr('src', filePath);
          $('#image-preview .preview-name').text('Existing Image');
          // Optional: tampilkan ukuran file jika tersedia
          $('#image-preview .preview-size').text('');
      }
    }
    // Handle Edit Button Click
    $('.edit-button').on('click', function() {
        const item = $(this).data('item');
        resetForm();
        fillForm(item);
        $('#modal-form').modal('show');
		// cek if image existing 
		if(item.file_path){
			originalImage = item.file_path;
			showExistingImage('item.file_path');
		}

		$('#btn-save').show();
		$('#modal-form').modal('show');
    });

    // File Upload Handler
	$('#filesop').on('change', function(e) {
        const file = this.files[0];
        if (file) {
            // Validate file type and size
            const validTypes = [
				'application/msword',         // .doc
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document', // .docx
            'application/pdf',            // .pdf
            'application/vnd.ms-excel',   // .xls
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' // .xlsx
  

			];
            const maxSize = 10 * 1024 * 1024; // 2MB

            if (!validTypes.includes(file.type)) {
                toastr.error('Format file tidak valid. Gunakan format JPG, JPEG, PNG, atau GIF');
                this.value = '';
                return;
            }

            if (file.size > maxSize) {
                toastr.error('Ukuran file terlalu besar. Maksimal 2MB');
                this.value = '';
                return;
            }

            // Show preview
            const reader = new FileReader();
            reader.onload = function(e) {
                // $('#image-preview')
                //     .removeClass('d-none')
                //     .find('img')
                //     .attr('src', e.target.result);
                // $('#image-preview .preview-name').text(file.name);
                // $('#image-preview .preview-size').text((file.size / 1024).toFixed(2) + ' KB');
				$('#file-preview')
				.removeClass('d-none')
				.html(`
					<p class="preview-name"><strong>Nama File:</strong> ${file.name}</p>
					<a href="${e.target.result}" download="${file.name}" class="btn btn-primary btn-sm">
						Download File
					</a>
				`);
            };
            reader.readAsDataURL(file);

            // Hide save button when file is selected as it will auto-submit
            $('#btn-save').hide();

            // Auto submit if form is valid
            if (validateForm()) {
                submitForm();
            }
        }
    });

    function validateFileUpload(file) {
        const validTypes = [
			'application/pdf',                                  // PDF format
        'application/msword',                               // DOC format
        'application/vnd.ms-excel',                        // XLS format
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document', // DOCX
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'

		];
        const maxSize = 10 * 1024 * 1024; // 2MB

        if (!validTypes.includes(file.type)) {
            toastr.error('Format file tidak valid. Gunakan format JPG, JPEG, PNG, atau GIF');
            return false;
        }

        if (file.size > maxSize) {
            toastr.error('Ukuran file terlalu besar. Maksimal 2MB');
            return false;
        }

        return true;
    }

    function showImagePreview(file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            // $('#image-preview')
            //     .removeClass('d-none')
            //     .find('img')
            //     .attr('src', e.target.result);
            // $('#image-preview .preview-name').text(file.name);
            // $('#image-preview .preview-size').text((file.size / 1024).toFixed(2) + ' KB');
			const fileName = file.name;
			const fileSize = (file.size / 1024).toFixed(2) + ' KB';
			const fileDownloadLink = e.target.result;

			$('#file-preview')
				.removeClass('d-none')
				.find('.preview-name')
				.text(fileName);
			$('#file-preview .preview-size').text(fileSize);

			// Set download link
			$('#file-preview .preview-download')
				.attr('href', fileDownloadLink)
				.attr('download', fileName) // Allow downloading with the original file name
				.text('Download');
		};
        reader.readAsDataURL(file);
    }

    // Handle Remove Image
    $('#remove-image').on('click', function() {
        $('#filesop').val('');
        $('#image-preview').addClass('d-none');
    });

    function resetForm() {
        $('#sop-form')[0].reset();
        $('#sop_id').val('');
        $('#modal-title').text('Tambah SOP');
        $('#filesop').prop('required', true);
        $('.file-required').show();
        $('#image-preview').addClass('d-none');
        $('#sop-form input').removeClass('is-invalid');
        $('.invalid-feedback').hide();
        $('.progress').addClass('d-none');
        updateProgressBar(0);
		originalImage=
        disableForm(false);
    }

    function fillForm(item) {
        $('#modal-title').text('Edit Gedung');
        $('#sop_id').val(item.id);
      
        $('#kategori').val(item.kategori);
        $('#filesop').prop('required', false);
        $('.file-required').hide();
    }

    // Delete functionality with confirmation modal
    $(document).on('click', '.delete-button', function(e) {
        e.preventDefault();
        const id = $(this).data('id');
        $('#delete-id').val(id);
        modalDelete.show();
    });

    $('#confirm-delete').on('click', function() {
        const id = $('#delete-id').val();
        $.ajax({
            url: `/sop/destroy/${id}`,
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                modalDelete.hide();
                toastr.success(response.success || "Data berhasil dihapus");
                setTimeout(() => {
                    location.reload();
                }, 1500);
            },
            error: function(xhr) {
                const message = xhr.responseJSON?.message || "Terjadi kesalahan saat menghapus data";
                toastr.error(message);
            }
        });
    });
});
</script>