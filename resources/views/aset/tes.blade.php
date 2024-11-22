<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Choices.js Dropdown in Bootstrap Modal</title>

  <!-- Memuat Bootstrap CSS -->
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

  <!-- Memuat Choices.js CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />

  <!-- Memuat jQuery (untuk Bootstrap) -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- Memuat Bootstrap JS -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

  <!-- Memuat Choices.js JS -->
  <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
</head>
<body>

<!-- Button untuk membuka modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
  Open Modal
</button>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myModalLabel">Choices.js Dropdown</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Elemen Select untuk Choices.js -->
        <select id="mySelect" class="form-control" multiple>
                                @foreach($brg as $r)
                                <option value="">{{ $r->namabarang }}</option>
                                @endforeach
        </select>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    // Inisialisasi Choices.js setelah modal ditampilkan
    $('#myModal').on('shown.bs.modal', function () {
      var element = document.getElementById('mySelect');
      var choices = new Choices(element, {
        searchEnabled: true,  // Mengaktifkan pencarian
        itemSelectText: '',   // Menghapus teks default di dropdown
        removeItemButton: true,  // Tombol untuk menghapus item yang dipilih (untuk multiple select)
        shouldSort: false,    // Menonaktifkan pengurutan otomatis (opsional)
      });
    });

    // Optional: Menghancurkan Choices.js saat modal ditutup
    $('#myModal').on('hidden.bs.modal', function () {
      var element = document.getElementById('mySelect');
      element.choices.destroy();  // Menghancurkan instansi Choices.js untuk modal ditutup
    });
  });
</script>

</body>
</html>
