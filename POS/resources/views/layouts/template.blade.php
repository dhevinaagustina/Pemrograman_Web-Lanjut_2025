<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'POS - Midterm Exam') }}</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Google Font: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <!-- AdminLTE -->
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">

    <!-- AOS Animation -->
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css" />

    <style>
      body {
          font-family: 'Poppins', sans-serif;
          background: #f8f8f8; /* Warm light gray */
      }
  
      .main-sidebar {
          background: linear-gradient(135deg, #2c7873 0%, #5dacbd 100%); /* Muted teal to soft blue */
      }
  
      .brand-text {
          font-weight: bold;
          font-size: 1rem;
          color: #fff !important;
      }
  
      .content-wrapper {
          padding: 20px;
      }
  
      .card {
          border-radius: 15px;
          box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
          background: linear-gradient(145deg, #ffffff 0%, #f4f4f4 100%); /* Soft white gradient */
          color: #333;
          border: none;
          transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
      }
  
      .card h4 {
          color: #2c7873; /* Muted teal */
          font-weight: 600;
      }
  
      .card p {
          color: #666;
      }
  
      .card:hover {
          transform: translateY(-3px);
          box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
      }
  
      .breadcrumb {
          background: transparent;
          font-size: 0.9rem;
      }
  
      .breadcrumb-item.active {
          color: #5dacbd; /* Soft blue */
      }
  
      .main-footer {
          background: transparent;
          border-top: 1px solid #e0e0e0;
          color: #666;
      }
  
      h1, h3 {
          color: #2c7873; /* Muted teal */
          font-weight: 600;
      }
  
      .btn-primary {
          background: #5dacbd; /* Soft blue */
          border-color: #5dacbd;
          transition: all 0.3s ease;
      }
  
      .btn-primary:hover {
          background: #2c7873; /* Muted teal */
          border-color: #2c7873;
      }
  </style>
  
  

    @stack('css')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Sidebar -->
    <aside class="main-sidebar elevation-4">
        <!-- Brand Logo -->
        <a href="{{ url('/') }}" class="brand-link">
            <img src="{{ asset('adminlte/dist/img/AdminLTELogo.png') }}" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .9">
            <span class="brand-text text-white">POS SYSTEM</span>
        </a>

        @include('layouts.sidebar')
    </aside>

    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <!-- Breadcrumb -->
        @include('layouts.breadcrumb')

        <!-- Main Content -->
        <section class="content">
            @yield('content')
        </section>
    </div>

    <!-- Footer -->
    @include('layouts.footer')
</div>

<!-- jQuery -->
<script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- DataTables & Plugins -->
<script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
<!-- SweetAlert2 -->
<script src="{{ asset('adminlte/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>

<!-- AOS Animation -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>

@stack('js')
</body>
</html>
