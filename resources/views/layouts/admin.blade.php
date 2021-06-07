<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name') }} | Dashboard</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- datatable -->
  <link rel="stylesheet" href="{{ config('app.asset_url') }}/vendor/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="{{ config('app.asset_url') }}/vendor/adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="{{ config('app.asset_url') }}/vendor/adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{ config('app.asset_url') }}/vendor/adminlte/plugins/fontawesome-free/css/all.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ config('app.asset_url') }}/vendor/adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <link rel="stylesheet" href="{{ config('app.asset_url') }}/vendor/adminlte/plugins/toastr/toastr.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ config('app.asset_url') }}/vendor/adminlte/dist/css/adminlte.min.css">
  @yield('css')<!-- all css in child views -->
</head>
<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__wobble" src="{{ config('app.asset_url') }}/vendor/adminlte/dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="fas fa-sign-out-alt"></i>
                <!--<span class="btn btn-danger navbar-badge">Sign-Out</span>-->
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <a class="dropdown-item text-center" href="{{ route('logout') }}" 
                    onclick="event.preventDefault();
                    document.getElementById('admin-logout-form').submit();">
                               
                    <!-- Message Start -->
                    <div class="btn btn-danger btn-lg">
                        Sign-Out
                    </div>
                </a>
                <form id="admin-logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </li>

        <li class="nav-item">
          <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
          </a>
        </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href='{{ route('admin.dashboard') }}' class="brand-link">
      <img src="{{ config('app.asset_url') }}/vendor/adminlte/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Admin SKAP</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ Auth::guard('web')->user()->name }}</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item menu-open">
            <a href="{{ route('admin.dashboard') }}" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <!--<i class="right fas fa-angle-left"></i>-->
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Products
                <i class="fas fa-angle-left right"></i>
                <!--<span class="badge badge-info right">6</span>-->
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('product.list') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Product List</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('product.categories') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Product Category</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-shopping-cart"></i>
              <p>
                Order
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('order.list') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Orders</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('order.report', ['from_date' => date('Y-m-d',strtotime("-1 years")), 'to_date' => date('Y-m-d')]) }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>GST Report</p>
                </a>
              </li>
            </ul>
          </li>
<!--          <li class="nav-item">
            <a href="{{ route('order.tax-setting') }}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Tax List
                <span class="right badge badge-danger">New</span>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tree"></i>
              <p>
                Users
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('customer.list') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Customers</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.user-list') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Admin Users</p>
                </a>
              </li>
            </ul>
          </li>-->
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  @yield('body')

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <strong>Copyright &copy; {{ date('Y') }} <a href="{{ route('admin.dashboard') }}"></a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.0.0
    </div>
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="{{ config('app.asset_url') }}/vendor/adminlte/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="{{ config('app.asset_url') }}/vendor/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- InputMask -->
<script src="{{ config('app.asset_url') }}/vendor/adminlte/plugins/moment/moment.min.js"></script>
<script src="{{ config('app.asset_url') }}/vendor/adminlte/plugins/inputmask/jquery.inputmask.min.js"></script>
<!-- overlayScrollbars -->
<script src="{{ config('app.asset_url') }}/vendor/adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="{{ config('app.asset_url') }}/vendor/adminlte/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- AdminLTE App -->
<script src="{{ config('app.asset_url') }}/vendor/adminlte/dist/js/adminlte.js"></script>
<!-- DataTables  & Plugins -->
<script src="{{ config('app.asset_url') }}/vendor/adminlte/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{ config('app.asset_url') }}/vendor/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ config('app.asset_url') }}/vendor/adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{ config('app.asset_url') }}/vendor/adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="{{ config('app.asset_url') }}/vendor/adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="{{ config('app.asset_url') }}/vendor/adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="{{ config('app.asset_url') }}/vendor/adminlte/plugins/jszip/jszip.min.js"></script>
<script src="{{ config('app.asset_url') }}/vendor/adminlte/plugins/pdfmake/vfs_fonts.js"></script>
<script src="{{ config('app.asset_url') }}/vendor/adminlte/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="{{ config('app.asset_url') }}/vendor/adminlte/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="{{ config('app.asset_url') }}/vendor/adminlte/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script src="{{ config('app.asset_url') }}/vendor/adminlte/plugins/toastr/toastr.min.js"></script>


<!-- AdminLTE for demo purposes -->
<script src="{{ config('app.asset_url') }}/vendor/adminlte/dist/js/demo.js"></script>

@yield('scripts')<!-- all scripts in child views -->
</body>
</html>
