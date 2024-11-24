<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="siap-unipa">
    <link rel="icon" href="{{asset('assets/images/favicon.ico')}}">
    <title>SIAP</title>
      <!-- Vendors Style-->
      <link rel="stylesheet" href="{{asset('assets/css/vendors_css.css')}}">
      <!-- Style-->  
      <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
      <link rel="stylesheet" href="{{asset('assets/css/skin_color.css')}}"> 

  </head>
<body class="hold-transition light-skin sidebar-mini theme-primary fixed">
  <!-- Loading Page -->
<div id="loading-overlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 9999; align-items: center; justify-content: center;">
    <div>
        <div class="spinner-border text-light" role="status">
            <span class="sr-only">Masih proses...</span>
        </div>
        <p class="text-light mt-3">Harap menunggu...</p>
    </div>
</div>

<div class="wrapper">
  <div id="loader"></div>	
    @include('layouts.partials.header')
    @include('layouts.partials.sidebar')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
	  <div class="container-full">
		<!-- Main content -->
		@yield('content')
		<!-- /.content -->
	  </div>
  </div>
  <!-- /.content-wrapper -->
  @include('layouts.partials.footer') 

  <!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>  
</div>	

	<script src="{{asset('assets/js/vendors.min.js')}}"></script>
	<!-- EduAdmin App -->
	<script src="{{asset('assets/js/template.js')}}"></script>
	<script src="{{asset('assets/vendor_components/datatable/datatables.min.js')}}"></script>
	<script src="{{asset('assets/js/pages/data-table.js')}}"></script>

  <script src="{{asset('assets/vendor_components/jquery-toast-plugin-master/src/jquery.toast.js')}}"></script>


 <script>
    // Function to show the loading overlay
  function showLoading() {
      document.getElementById('loading-overlay').style.display = 'flex';
  }
  // Function to hide the loading overlay
  function hideLoading() {
      document.getElementById('loading-overlay').style.display = 'none';
  }
  // Show loading during page reload
  window.addEventListener('beforeunload', function () {
      showLoading();
 });

// Logout process
let idleTime = 0;
        const idleInterval = setInterval(timerIncrement, 60000); // 1 menit

        // Reset timer pada mouse movement, keypress, scroll
        document.addEventListener('mousemove', resetTimer);
        document.addEventListener('keypress', resetTimer);
        document.addEventListener('scroll', resetTimer);
        
        function resetTimer() {
            idleTime = 0;
        }

        function timerIncrement() {
            idleTime = idleTime + 1;
            if (idleTime >= 1) { // Jika idle 1 menit
                // Kirim request logout
                fetch('/logout', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                }).then(() => {
                    window.location.href = '/login';
                });
            }
        }
 </script>
</body>
</html>
