<!-- Add in head section or after css includes -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" rel="stylesheet">


<!-- Modal Add form -->
<div class="modal " id="modal-right" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah unit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form-unit">
                    @csrf             
                    <div class="mb-3">
                        <label for="kode_gedung" class="form-label">Kode gedung</label>
                        <select id="kode_gedung" class="form-control" name="kode_gedung" required>
                            @foreach($ged as $r)
                            <option value="{{$r->kode_gedung}}">{{$r->nama_gedung}}</option>
							@endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="nama_gedung" class="form-label">Nama Gedung</label>
                        <input type="text" id="nama_gedung" class="form-control" placeholder="Nama Gedung" name="nama_gedung" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="lantai" class="form-label">Lantai</label>
                        <select  class="form-control" id="lantai" name="lantai" required>
                            <option disabled>Pilih Lantai</option>
                            <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="nama_unit" class="form-label">Nama Unit</label>
                        <input type="text" class="form-control" id="nama_unit" name="nama_unit" required>
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
<div class="modal" id="modal-edit-barang" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Unit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="edit-form"  action="{{Route('unit.update')}}" method="Post">
                    <input type="hidden" id="edit-id" name="id">
                    <div class="box-body">
                        <div class="mb-3">
                            <label for="edit-kode-gedung" class="form-label">Kode gedung</label>
                            <select id="edit-kode-gedung" class="form-control" name="kode_gedung" required>
                                <option value="">Pilih Kode Gedung</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit-nama-gedung" class="form-label">Nama Gedung</label>
                            <input type="text" id="edit-nama-gedung" class="form-control" placeholder="Nama Gedung" name="nama_gedung" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="edit-lantai" class="form-label">Lantai</label>
                            <select type="text" class="form-control" id="edit-lantai" name="lantai" required>
                                <option disabled>Pilih Lantai</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit-nama-unit" class="form-label">Nama Unit</label>
                            <input type="text" class="form-control" id="edit-nama-unit" name="nama_unit" required>
                        </div>
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

<!-- Modal Delete (unchanged) -->
<div class="modal fade" id="modal-delete-unit" tabindex="-1">
<div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDeleteunitLabel">Delete unit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this item?</p>
                <form id="form-delete-unit">
                    @csrf
                    @method('DELETE')  <!-- Specify DELETE method for deletions -->
                    <input type="hidden" id="delete-id" name="id">  <!-- Hidden field for ID -->
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" onclick="submitDeleteForm()">Delete</button>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>



<script type="text/javascript">
    let addChoices, editChoices;
$(document).ready(function() {
    // Toastr options

    
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "timeOut": "3000"
    };

  

  
    initializeChoices();
    // Fetch initial data
    fetchKodeGedung();

    // Setup event handlers

});
    function fetchKodeGedung() {
    $.ajax({
        url: '/api/get-kode-gedung',
        method: 'GET',
        success: function (response) {
            if (response && Array.isArray(response)) {
                const choices = response.map(item => ({
                    value: item.kode_gedung,
                    label: item.kode_gedung
                }));

                editChoices.clearChoices();
                editChoices.setChoices(choices);
            }
        },
        error: function (xhr, status, error) {
            toastr.error('Gagal mengambil data kode gedung');
            console.error('Error fetching kode gedung:', error);
        }
        });
    }

    fetchKodeGedung();

    // Event listener for kode_gedung change
    document.getElementById('kode_gedung').addEventListener('change', function(event) {
        handleKodeGedungChange(event.target.value, '#nama_gedung');
    });

    document.getElementById('edit-kode-gedung').addEventListener('change', function(event) {
    const kodeGedung = event.target.value;
    if (kodeGedung) {
        $.ajax({
            url: '/api/get-nama-gedung',
            method: 'GET',
            data: { kode_gedung: kodeGedung },
            success: function (response) {
                $('#edit-nama-gedung').val(response.nama_gedung || '');
            },
            error: function () {
                toastr.error('Gagal mengambil data nama gedung');
                $('#edit-nama-gedung').val('');
            }
        });
        } else {
            $('#edit-nama-gedung').val('');
        }
    });

    function handleKodeGedungChange(kodeGedung, targetInput) {
        if (!kodeGedung) {
            $(targetInput).val('');
        return;
        }  $.ajax({
                url: '/api/get-nama-gedung',
                method: 'GET',
                data: { kode_gedung: kodeGedung },
                success: function (response) {
                    $(targetInput).val(response.nama_gedung || '');
                },
                error: function () {
                    toastr.error('Gagal mengambil data nama gedung');
                    $(targetInput).val('');
                }
            });
    }

    // Reset choices when modal is hidden
    $('#modal-right').on('hidden.bs.modal', function () {
        addChoices.clearStore();
        $('#form-unit')[0].reset();
    });

    $('#modal-edit-barang').on('hidden.bs.modal', function () {
        $('#edit-form')[0].reset();
        $(this).removeData('original');
        editChoices.clearStore();
    });

    // Edit button click handler
    $('.edit-button').on('click', function () {
    var item = $(this).data('item');
    if (item) {
        // Store original data for comparison
        $('#modal-edit-barang').data('original', {...item});
        
        // Set form values
        $('#edit-id').val(item.id);
        editChoices.setChoiceByValue(item.kode_gedung);
        $('#edit-nama-gedung').val(item.nama_gedung);
        $('#edit-lantai').val(item.lantai);
        $('#edit-nama-unit').val(item.nama_unit);
    }
    $('#modal-edit-barang').modal('show');
});

    // Delete button click handler
    $('.delete-button').on('click', function() {
        var id = $(this).data('id');
        $('#delete-id').val(id);
        $('#modal-delete-unit').modal('show');
        });


// Form submission functions
function submitForm() {
    if(!$('#form-unit')[0].checkValidity()) {
        $('#form-unit')[0].reportValidity();
        return;
    }

    $.ajax({
        url: "{{ URL('/unit/store') }}",
        method: "POST",
        data: $('#form-unit').serialize(),
        success: function(response) {
            toastr.success('Data berhasil disimpan');
            $('#modal-right').modal('hide');
            setTimeout(function() {
                location.reload();
            }, 1000);
        },
        error: function(xhr, status, error) {
            toastr.error('Gagal menyimpan data');
        }
    });
}

function submitEditForm() {
    const form = $('#edit-form')[0];
    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }
    const selectedChoice = editChoices.getValue(true);
    console.log('Selected choice:', selectedChoice);

    const formData = {
        id: $('#edit-id').val(),
        kode_gedung: selectedChoice.value,
        nama_gedung: selectedChoice.customProperties?.nama_gedung || $('#edit-nama-gedung').val(),
        lantai: $('#edit-lantai').val(),
        nama_unit: $('#edit-nama-unit').val(),
        _token: $('meta[name="csrf-token"]').attr('content')
    };
    console.log('Form data to be sent:', formData);

    // Validasi data penting
    if (!formData.id) {
        toastr.error('ID tidak valid');
        return;
    }

    $.ajax({
        url: '/unit/update',
        method: 'POST',
        data: formData,
        success: function(response) {
            console.log('Update response:', response);
            toastr.success('Data berhasil diupdate');
            $('#modal-edit-barang').modal('hide');
            setTimeout(() => location.reload(), 1000);
        },
        error: function(xhr, status, error) {
            console.error('Update error:', xhr.responseText);
            const errorMessage = xhr.responseJSON?.message || 'Unknown error';
            toastr.error(`Gagal mengupdate data: ${errorMessage}`);
        }
    });
}

// Delete function remains the same
function submitDeleteForm() {
        var formData = $('#form-delete-unit').serialize();
        var id = $('#delete-id').val();

        $.ajax({
            url: `/unit/hapus/${id}`,
            method: "POST",
            data:  {
                _token: $('meta[name="csrf-token"]').attr('content') // Include CSRF token
            },
            success: function(response) {
                alert("Data deleted successfully!");
                $('#modal-delete-unit').modal('hide');
                location.reload();  // Reload to see updated data
            },
            error: function(xhr, status, error) {
                alert("Failed to delete data. Please try again.");
            }
        });
    }

function initializeChoices() {
    // Initialize Choices.js for add form
    addChoices = new Choices('#kode_gedung', {
        searchEnabled: true,
        removeItemButton: true,
        placeholder: true,
        placeholderValue: 'Pilih Kode Gedung'
    });

    // Initialize Choices.js for edit form
    editChoices = new Choices('#edit-kode-gedung', {
        searchEnabled: true,
        removeItemButton: true,
        placeholder: true,
        placeholderValue: 'Pilih Kode Gedung'
    });

    // Fetch initial data for edit form
    fetchKodeGedung();
}
function setupEventHandlers() {
    // Event listener untuk perubahan kode gedung
    $('#kode_gedung, #edit-kode-gedung').on('change', function() {
        const targetInput = this.id === 'kode_gedung' ? '#nama_gedung' : '#edit-nama-gedung';
        handleKodeGedungChange(this.value, targetInput);
    });

    // Reset modal saat ditutup
    $('#modal-right').on('hidden.bs.modal', function() {
        $('#form-unit')[0].reset();
        if (addChoices) addChoices.clearStore();
    });

    $('#modal-edit-barang').on('hidden.bs.modal', function() {
        $('#edit-form')[0].reset();
        if (editChoices) editChoices.clearStore();
    });

    // Handler tombol edit dan delete
    $(document).on('click', '.edit-button', function() {
        const item = $(this).data('item');
        if (item) {
            openEditModal(item);
        }
    });

    $(document).on('click', '.delete-button', function() {
        const id = $(this).data('id');
        $('#delete-id').val(id);
        $('#modal-delete-unit').modal('show');
    });
}
function openEditModal(item) {
    try {
        console.log('Opening edit modal with item:', item);
        
        // Store original data for comparison
        $$('#edit-form')[0].reset();
        
        // Set form values
        $('#edit-id').val(item.id);
        $('#edit-lantai').val(item.lantai);
        $('#edit-nama-unit').val(item.nama_unit);
        $('#edit-nama-gedung').val(item.nama_gedung);

        // Make sure editChoices is initialized
        if (item.kode_gedung) {
            fetchKodeGedung().then(() => {
                if (editChoices) {
                    editChoices.setChoiceByValue(item.kode_gedung);
                }
            });
        }

        $('#modal-edit-barang').modal('show');
    } catch (error) {
        console.error('Error in openEditModal:', error);
        toastr.error('Gagal membuka form edit');
    }
}
</script>
 