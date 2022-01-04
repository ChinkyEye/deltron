<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  {{-- <link rel="shortcut icon" href="{{ asset('image/IMG.jpg') }}"> --}}
  {{-- <link rel="icon" href="{{ asset('image/IMG.jpg') }}"> --}}
  {{-- <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}"> --}}
  <title>Scheme Management | Manager</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Bootstrap 3.3.7 -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  {{-- <link href="{{ asset('css/overlay.css') }}" rel="stylesheet"> --}}
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper" id="app">
    <vue-progress-bar></vue-progress-bar>
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <!-- Messages Dropdown Menu -->
        {{-- <li class="nav-item">
          <router-link :to="{ name: 'fiscalyear' }" class="nav-link"><i class="fas fa-cogs"></i>Fiscal Year</router-link>
        </li> --}}
        <li>
          <router-link to="/changepassword" class="nav-link">
            <i class="nav-icon fas fa-key"></i>
            Change Password
          </router-link>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-user"></i>
            Welcome, {{Auth::user()->name}}
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
              {{ __('Logout') }} 
              <i class="fas fa-sign-out-alt"></i>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
            </form>
          </div>
        </li>
        <!-- right -->
       {{--  <li class="nav-item">
          <router-link :to="{ name: 'report' }" class="nav-link"><i class="fas fa-cogs"></i>Report</router-link>
        </li> --}}
        {{-- <li class="nav-item">
          <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="javascript:void(0);">
            <i class="fas fa-th-large"></i>
          </a>
        </li> --}}
        <li class="nav-item">
             <router-link :to="{ name: 'report' }" class="nav-link"><i class="fas fa-th-large"></i></router-link>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->
    <!-- <vue-progress-bar></vue-progress-bar> -->
    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="#" class="brand-link">

        <img :src="`/image/manager/thumbnail/{{Auth::user()->image_enc}}`" alt="Techware Logo" class="brand-image elevation-3">
        {{-- <img src="{{ asset('image/IMG.jpg') }}" alt="Techware Logo" class="brand-image elevation-3"> --}}
        <span class="brand-text font-weight-light">Manager</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image pt-1">
            @php preg_match_all('/(?<=\s|^)[a-z]/i', Auth::user()->name, $matches); @endphp
            <span class="border border-light rounded-circle py-1 {{count($matches[0]) == 1 ? 'px-2' : 'px-'.(3-count($matches[0]))}} bg-success text-light text-capitalize elevation-3">{{strtoupper(implode('', $matches[0]))}}</span>
          </div>
          <div class="info">
            <router-link :to="{ name: 'dashboard' }" class="d-block">{{Auth::user()->name}}</router-link>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <!-- sidebar -->
          <sidebar></sidebar>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>
    <!-- Control right Sidebar -->
    <header-report></header-report>
    <!-- /.control-right-sidebar -->
    <!-- <dialogue ref="abc"></dialogue> -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <manager-main></manager-main>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
      <strong>Copyright &copy; 2020 <a href="https://www.techware.com.np">Techware Pvt Ltd</a>.</strong>
      All rights reserved.
      <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 1.0.0
      </div>
    </footer>

  </div>
  <!-- ./wrapper -->

  <script src="{{ asset('js/managerapp.js') }}" defer></script>
  {{-- <script src="{{ asset('js/overlay.js') }}" defer></script> --}}


</body>
</html>
