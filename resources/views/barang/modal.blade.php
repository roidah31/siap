<!-- Add required CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">

<!-- Modal Add -->
<div class="modal fade" id="modal-barang" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Barang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form-barang">
                    @csrf
                    <div class="mb-3">
                        <label for="namabarang" class="form-label">Nama Barang</label>
                        <input type="text" class="form-control" id="namabarang" name="namabarang" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="submitForm()">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="modal-edit-barang" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Barang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="edit-form">
                    @csrf
                    <input type="hidden" id="edit-id" name="id">
                    <div class="mb-3">
                        <label for="edit-nama-barang" class="form-label">Nama Barang</label>
                        <input type="text" class="form-control" id="edit-nama-barang" name="namabarang" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="submitEditForm()">Update</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Delete -->
<div class="modal fade" id="modal-delete-barang" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Barang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this item?</p>
                <form id="form-delete-barang">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" id="delete-id" name="id">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" onclick="submitDeleteForm()">Delete</button>
            </div>
        </div>
    </div>
</div>

<!-- Required Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
$(document).ready(function() {
    // Configure toastr
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "timeOut": "3000"
    };

    // Setup event handlers
    setupEventHandlers();
});

function setupEventHandlers() {
    // Edit button handler
    $('.edit-button').on('click', function() {
        const item = $(this).data('item');
        if (item) {
            openEditModal(item);
        }
    });

    // Delete button handler
    $('.delete-button').on('click', function() {
        const id = $(this).data('id');
        $('#delete-id').val(id);
        $('#modal-delete-barang').modal('show');
    });

    // Reset form on modal close
    $('#modal-barang').on('hidden.bs.modal', function() {
        $('#form-barang')[0].reset();
    });

    $('#modal-edit-barang').on('hidden.bs.modal', function() {
        $('#edit-form')[0].reset();
    });
}

function openEditModal(item) {
    $('#edit-id').val(item.id);
    $('#edit-nama-barang').val(item.namabarang);
    $('#modal-edit-barang').modal('show');
}

function submitForm() {
    const form = $('#form-barang')[0];
    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }

    $.ajax({
        url: "{{URL('/barang/store')}}",
        method: "POST",
        data: $('#form-barang').serialize(),
        success: function(response) {
            toastr.success('Data berhasil disimpan');
            $('#modal-barang').modal('hide');
            setTimeout(() => location.reload(), 1000);
        },
        error: function(xhr, status, error) {
            console.error('Save error:', error);
            toastr.error('Gagal menyimpan data: ' + (xhr.responseJSON?.message || error));
        }
    });
}

function submitEditForm() {
    const form = $('#edit-form')[0];
    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }

    const formData = {
        id: $('#edit-id').val(),
        namabarang: $('#edit-nama-barang').val(),
        _token: $('meta[name="csrf-token"]').attr('content')
    };

    $.ajax({
        url: '{{URL('/barangubah')}}',
        method: "POST",
        data: formData,
        success: function(response) {
            toastr.success('Data berhasil diupdate');
            $('#modal-edit-barang').modal('hide');
            setTimeout(() => location.reload(), 1000);
        },
        error: function(xhr, status, error) {
            console.error('Update error:', error);
            toastr.error('Gagal mengupdate data: ' + (xhr.responseJSON?.message || error));
        }
    });
}

function submitDeleteForm() {
    const id = $('#delete-id').val();
    if (!id) {
        toastr.error('ID tidak ditemukan');
        return;
    }

    if (!confirm('Anda yakin ingin menghapus data ini?')) {
        return;
    }

    $.ajax({
        url: `{{URL('/barang/hapus')}}/+${id}`,
        method: "POST",
        data: {
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            toastr.success('Data berhasil dihapus');
            $('#modal-delete-barang').modal('hide');
            setTimeout(() => location.reload(), 1000);
        },
        error: function(xhr, status, error) {
            console.error('Delete error:', error);
            toastr.error('Gagal menghapus data');
        }
    });
}
</script>
