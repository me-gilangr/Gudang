<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>AdminLTE 3 | Starter</title>

  <link rel="stylesheet" href="{{ asset('backend') }}/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('backend') }}/dist/css/adminlte.min.css">
  <link href="{{ asset('backend') }}/font/Sans-Pro.css" rel="stylesheet">

  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('backend') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="{{ asset('backend') }}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

  <!-- Toastr -->
  <link rel="stylesheet" href="{{ asset('backend') }}/plugins/toastr/toastr.min.css">

  <!-- Lightbox2 -->
  <link rel="stylesheet" href="{{ asset('backend') }}/other/lightbox2/css/lightbox.css">

  
  <style>
    .flat {
      border-radius: 0px !important;
    } 
  </style>

  @yield('css')
</head>
<body class="hold-transition sidebar-mini text-sm">
<div class="wrapper">

  @include('backend.layouts.navbar')

  @include('backend.layouts.sidebar')

  <div class="content-wrapper">
    <div class="content-header" style="padding: 10px !important;">
      
    </div>

    <div class="content">
      <div class="container-fluid">
        <div class="row">
          @yield('content')
        </div>
      </div>
    </div>
  </div>

  <aside class="control-sidebar control-sidebar-dark">
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>

  @include('backend.layouts.footer')
</div>


<script src="{{ asset('backend') }}/plugins/jquery/jquery.min.js"></script>
<script src="{{ asset('backend') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('backend') }}/dist/js/adminlte.min.js"></script>

<!-- DataTables -->
<script src="{{ asset('backend') }}/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{ asset('backend') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ asset('backend') }}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{ asset('backend') }}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

<!-- Toastr -->
<script src="{{ asset('backend') }}/plugins/toastr/toastr.min.js"></script>


<!-- Lightbox2 -->
<script src="{{ asset('backend') }}/other/lightbox2/js/lightbox.js"></script>

<script>
	function toastError(message) {
		toastr.error(message, "Peringatan");
	}
	
	function toastSuccess(message) {
		toastr.success(message, "Berhasil");
	}
	
	function toastWarning(message) {
		toastr.warning(message, "Perhatian");
	}

  function toastInfo(message) {
    toastr.info(message, "Informasi");
  }
</script>

@if (session('success'))
<script>
	toastr.success("{{ session('success') }}", "Berhasil");
</script>
@endif

@if (session('error'))
<script>
	toastr.error("{{ session('error') }}", "Peringatan");
</script>
@endif

@if (session('warning'))
<script>
	toastr.warning("{{ session('warning') }}", "Perhatian");
</script>
@endif

@if (session('info'))
<script>
	toastr.info("{{ session('info') }}", "Info");
</script>
@endif

@yield('script')

</body>
</html>
