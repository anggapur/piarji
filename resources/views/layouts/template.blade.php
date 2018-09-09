<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{ config('app.name', 'Laravel') }}</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Drop down -->
  <!-- DROPDOWN -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{ asset('public/template/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('public/template/bower_components/font-awesome/css/font-awesome.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ asset('public/template/bower_components/Ionicons/css/ionicons.min.css')}}">
   <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('public/template/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('public/template/dist/css/AdminLTE.min.css')}}">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{ asset('public/template/dist/css/skins/_all-skins.min.css')}}">
  <!-- Morris chart -->
  <link rel="stylesheet" href="{{ asset('public/template/bower_components/morris.js/morris.css')}}">
  <!-- jvectormap -->
  <link rel="stylesheet" href="{{ asset('public/template/bower_components/jvectormap/jquery-jvectormap.css')}}">
  <!-- Date Picker -->
  <link rel="stylesheet" href="{{ asset('public/template/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ asset('public/template/bower_components/bootstrap-daterangepicker/daterangepicker.css')}}">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="{{ asset('public/template/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}">
  <link rel="stylesheet" href="{{ asset('public/template/style.css')}}" type="text/css" media="all">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

  <!-- jQuery 3 -->
<script src="{{ asset('public/template/bower_components/jquery/dist/jquery.min.js')}}"></script>
<!-- CKEDITOR -->
<script src="//cdn.ckeditor.com/4.10.0/full/ckeditor.js"></script>
<!-- HTML to PDF -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.4.1/jspdf.debug.js" integrity="sha384-THVO/sM0mFD9h7dfSndI6TS0PgAGavwKvB5hAxRRvc0o9cPLohB0wb/PTA7LdUHs" crossorigin="anonymous"></script>

<style type="text/css">
  
@media print
{
  .noprint {display:none;}
}
</style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="{{url('home')}}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini">{{ config('app.nickname', 'Laravel') }}</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg">{{ config('app.name', 'Laravel') }}</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">          
          <!-- User Account: style can be found in dropdown.less -->
          @if(Auth::user()->level == "operator")
          <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-envelope-o"></i>
              <span class="label label-success">{{collect(CH::getNotifTerimaMutasi())->count()}}</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">Ada {{collect(CH::getNotifTerimaMutasi())->count()}} Mutasi Pegawai Dari Satker Lain</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  @foreach(CH::getNotifTerimaMutasi() as $val)
                  <li><!-- start message -->
                    <a href="{{url('mutasiSetting/terimaMutasi')}}">                      
                      <h4>
                        {{$val->dari_satker}} - {{$val->nm_satker}}                   
                      </h4>
                      <p>{{$val->nip}} - {{$val->nama}}</p>
                    </a>
                  </li>
                  @endforeach                 
                </ul>
              </li>
              <li class="footer"><a href="{{url('mutasiSetting/terimaMutasi')}}">Lihat Semua Mutasi Masuk</a></li>
            </ul>
          </li>
          @endif

          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="{{asset('public/template/dist/img/user2-160x160.jpg')}}" class="user-image" alt="User Image">
              <span class="hidden-xs">{{Auth::user()->name}}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="{{asset('public/template/dist/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image">

                <p>
                  {{Auth::user()->name}}
                  <small>{{CH::getSatker()}}</small>
                </p>
              </li>
              <!-- Menu Body -->
              
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="{{url('profile')}}" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="{{route('logout')}}" class="btn btn-default btn-flat" onclick="event.preventDefault(); document.getElementById('frm-logout').submit();">Logout</a>
                  <form id="frm-logout" action="{{ route('logout') }}" method="POST" style="display: none;">
                      {{ csrf_field() }}
                  </form>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{asset('public/template/dist/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>{{Auth::user()->name}}</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
     
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <!-- <li class="header">MAIN NAVIGATION</li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class=""><a href="index.html"><i class="fa fa-circle-o"></i> Dashboard v1</a></li>
            <li><a href="index2.html"><i class="fa fa-circle-o"></i> Dashboard v2</a></li>
          </ul>
        </li> -->
        <!-- MENU HOME -->
        <li class="{{CH::segment(1,['home'])}}"><a href="{{url('')}}"><i class="fa fa-book"></i> <span>Home</span></a></li>       
        <!-- MENU ABSENSI-->
        <li class="{{CH::segment(1,['absensi'])}} {{CH::showTo(['operator'])}}"><a href="{{url('absensi')}}"><i class="fa fa-list-alt"></i> <span>Rekap Absensi</span></a></li> 
        <li class="{{CH::segment(1,['absensiSusulan'])}} {{CH::showTo(['operator'])}}"><a href="{{url('absensiSusulan')}}"><i class="fa fa-list-alt"></i> <span>Rekap Absensi Susulan</span></a></li> 

        <!-- Menu Setting User -->        
        <li class="{{CH::segment(1,['settingUser'])}} {{CH::showTo(['admin'])}} treeview">
          <a href="#">
            <i class="fa fa-gear"></i> <span>Setting User</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{CH::segment(2,['create'])}}"><a href="{{url('settingUser/create')}}"><i class="fa fa-circle-o"></i> Tambah User</a></li>
            <li class="{{CH::segment(2,[''])}}"><a href="{{url('settingUser')}}"><i class="fa fa-circle-o"></i> Lihat User</a></li>
          </ul>
        </li>  

        <!-- Aturan Tunkin -->        
        <li class="{{CH::segment(1,['aturanTunkin'])}} {{CH::showTo(['admin'])}} treeview">
          <a href="#">
            <i class="fa fa-gear"></i> <span>Setting Kebijakan Tunkin</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{CH::segment(2,['create'])}}"><a href="{{url('aturanTunkin/create')}}"><i class="fa fa-circle-o"></i> Input Aturan Tunkin</a></li>
            <li class="{{CH::segment(2,[''])}}"><a href="{{url('aturanTunkin')}}"><i class="fa fa-circle-o"></i> Lihat Aturan Tunkin</a></li>
          </ul>
        </li>  

        <!-- Kebijakan Absensi -->
         <li class="{{CH::segment(1,['kebijakanAbsensi'])}} {{CH::showTo(['admin'])}} treeview">
          <a href="#">
            <i class="fa fa-gear"></i> <span>Setting Kebijakan Absensi</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{CH::segment(2,[''])}} {{CH::showTo(['admin'])}}"><a href="{{url('kebijakanAbsensi')}}"><i class="fa fa-circle-o"></i> Kebijakan Absensi</a></li>            
          </ul>
        </li>  

        <!-- Menu Setting User -->        
        <li class="{{CH::segment(1,['settingRekening','pegawaiSetting','dataPegawai'])}} {{CH::showTo(['admin','operator'])}} treeview">
          <a href="#">
            <i class="fa fa-gear"></i> <span>Data Personil</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <!-- <li class="{{CH::segment(2,['importForm'])}}"><a href="{{url('settingRekening/importForm')}}"><i class="fa fa-circle-o"></i> Import Data Rekening</a></li> -->
            <li class="{{CH::segment(2,['create'])}}"><a href="{{url('dataPegawai/create')}}"><i class="fa fa-circle-o"></i> Input Personil</a></li>
            <li class="{{CH::segment(2,[''])}}"><a href="{{url('settingRekening')}}"><i class="fa fa-circle-o"></i> Lihat Personil</a></li>
            <li class="{{CH::segment(2,['importPegawai'])}}"><a href="{{url('pegawaiSetting/importPegawai')}}"><i class="fa fa-circle-o"></i> Import Data Personil</a></li>
          </ul>
        </li> 

 <!-- Menu Setting User -->        
        <li class="{{CH::segment(1,['dataSatker'])}} {{CH::showTo(['admin'])}} treeview">
          <a href="#">
            <i class="fa fa-gear"></i> <span>Data Satker</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <!-- <li class="{{CH::segment(2,['importForm'])}}"><a href="{{url('settingRekening/importForm')}}"><i class="fa fa-circle-o"></i> Import Data Rekening</a></li> -->
            <li class="{{CH::segment(2,['create'])}}"><a href="{{url('dataSatker/create')}}"><i class="fa fa-circle-o"></i> Input Satker</a></li>
            <li class="{{CH::segment(2,[''])}}"><a href="{{url('dataSatker')}}"><i class="fa fa-circle-o"></i> Lihat Satker</a></li>
            <li class="{{CH::segment(2,['importPegawai'])}}"><a href="{{url('dataSatker/importSatker')}}"><i class="fa fa-circle-o"></i> Import Data Satker</a></li>
          </ul>
        </li> 


        <!-- Menu Setting User -->        
        <li class="{{CH::segment(1,['tandaTanganSetting'])}} {{CH::showTo(['admin','operator'])}} treeview">
          <a href="#">
            <i class="fa fa-gear"></i> <span>Isi Laporan</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{CH::segment(2,['laporan1'])}}"><a href="{{url('tandaTanganSetting/laporan1')}}"><i class="fa fa-circle-o"></i> Laporan C1/C2</a></li>            
            <li class="{{CH::segment(2,['laporanB'])}}"><a href="{{url('tandaTanganSetting/laporanB')}}"><i class="fa fa-circle-o"></i> Laporan B1/B2</a></li>            
            <li class="{{CH::segment(2,['laporanSPP'])}}"><a href="{{url('tandaTanganSetting/laporanSPP')}}"><i class="fa fa-circle-o"></i> Laporan SPP</a></li>            
            <li class="{{CH::segment(2,['laporanKU'])}}"><a href="{{url('tandaTanganSetting/laporanKU')}}"><i class="fa fa-circle-o"></i> Laporan KU</a></li>            
            <li class="{{CH::segment(2,['laporanSPTJM'])}}"><a href="{{url('tandaTanganSetting/laporanSPTJM')}}"><i class="fa fa-circle-o"></i> Laporan SPTJM</a></li> 
          </ul>
        </li> 

        <!-- Menu Setting User -->        
        <li class="{{CH::segment(1,['laporanAbsensi'])}} {{CH::showTo(['admin','operator'])}} treeview">
          <a href="#">
            <i class="fa fa-gear"></i> <span>Cetak Laporan</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{CH::segment(2,['laporan1'])}}"><a href="{{url('laporanAbsensi/laporan1')}}"><i class="fa fa-circle-o"></i> Laporan C1/C2</a></li>            
            <li class="{{CH::segment(2,['laporanB'])}}"><a href="{{url('laporanAbsensi/laporanB')}}"><i class="fa fa-circle-o"></i> Laporan B1/B2</a></li>            
            <li class="{{CH::segment(2,['laporanSPP'])}}"><a href="{{url('laporanAbsensi/laporanSPP')}}"><i class="fa fa-circle-o"></i> Laporan SPP</a></li>            
            <li class="{{CH::segment(2,['laporanKU'])}}"><a href="{{url('laporanAbsensi/laporanKU')}}"><i class="fa fa-circle-o"></i> Laporan KU</a></li>            
            <li class="{{CH::segment(2,['laporanSPTJM'])}}"><a href="{{url('laporanAbsensi/laporanSPTJM')}}"><i class="fa fa-circle-o"></i> Laporan SPTJM</a></li>
          </ul>
        </li> 

        <li class="{{CH::segment(1,['laporanAbsensiSusulan'])}} {{CH::showTo(['admin','operator'])}} treeview">
          <a href="#">
            <i class="fa fa-gear"></i> <span>Cetak Laporan Susulan</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{CH::segment(2,['laporan1'])}}"><a href="{{url('laporanAbsensiSusulan/laporan1')}}"><i class="fa fa-circle-o"></i> Laporan C1/C2</a></li>            
            <li class="{{CH::segment(2,['laporanB'])}}"><a href="{{url('laporanAbsensiSusulan/laporanB')}}"><i class="fa fa-circle-o"></i> Laporan B1/B2</a></li>            
            <li class="{{CH::segment(2,['laporanSPP'])}}"><a href="{{url('laporanAbsensiSusulan/laporanSPP')}}"><i class="fa fa-circle-o"></i> Laporan SPP</a></li>            
            <li class="{{CH::segment(2,['laporanKU'])}}"><a href="{{url('laporanAbsensiSusulan/laporanKU')}}"><i class="fa fa-circle-o"></i> Laporan KU</a></li>            
            <li class="{{CH::segment(2,['laporanSPTJM'])}}"><a href="{{url('laporanAbsensiSusulan/laporanSPTJM')}}"><i class="fa fa-circle-o"></i> Laporan SPTJM</a></li>
          </ul>
        </li> 


        <!-- Menu Setting User -->        
        <li class="{{CH::segment(1,['mutasiSetting'])}} {{CH::showTo(['operator'])}} treeview">
          <a href="#">
            <i class="fa fa-gear"></i> <span>Mutasi</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{CH::segment(2,['kirimMutasi'])}}"><a href="{{url('mutasiSetting/kirimMutasi')}}"><i class="fa fa-circle-o"></i> Kirim Mutasi</a></li>
            <li class="{{CH::segment(2,[''])}}"><a href="{{url('mutasiSetting')}}"><i class="fa fa-circle-o"></i> Mutasi Keluar</a></li>            
            <li class="{{CH::segment(2,['terimaMutasi'])}}"><a href="{{url('mutasiSetting/terimaMutasi')}}"><i class="fa fa-circle-o"></i> Terima Mutasi</a></li>                        
          </ul>
        </li> 

        <li class="{{CH::segment(2,['mutasiViewAdmin'])}} {{CH::showTo(['admin'])}}"><a href="{{url('mutasiSetting/mutasiViewAdmin')}}"><i class="fa fa-book"></i> <span>Mutasi</span></a></li>
        

        <!-- Sinkronisasi -->
        <!-- <li class="{{CH::segment(1,['sinkronisasiData'])}}"><a href="{{url('sinkronisasiData')}}"><i class="fa fa-book"></i> <span>Sinkronisasi Data</span></a></li> -->

        <!--  Backup Restore-->
        <li class="{{CH::segment(1,['backupRestore'])}} {{CH::showTo(['admin'])}} treeview">
          <a href="#">
            <i class="fa fa-gear"></i> <span>Backup & Restore</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{CH::segment(2,['backup'])}}"><a href="{{url('backupRestore/backup')}}"><i class="fa fa-circle-o"></i> Backup</a></li>            
            <li class="{{CH::segment(2,['restore'])}}"><a href="{{url('backupRestore/restore')}}"><i class="fa fa-circle-o"></i> Restore</a></li>            
          </ul>
        </li> 

        <!-- Menu Data MAster -->
        <!-- <li class="{{CH::segment(1,['dataSatker','dataUnit','dataDept','dataJabatan','dataLokasi','dataPangkat','dataPegawai'])}} {{CH::showTo(['admin','operator'])}} treeview">
          <a href="#">
            <i class="fa fa-gear"></i> <span>Data Master</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{CH::segment(1,['dataSatker'])}}"><a href="{{url('dataSatker')}}"><i class="fa fa-circle-o"></i> Data Satker</a></li>
            <li class="{{CH::segment(1,['dataUnit'])}}"><a href="{{url('dataUnit')}}"><i class="fa fa-circle-o"></i> Data Unit</a></li>
            <li class="{{CH::segment(1,['dataDept'])}}"><a href="{{url('dataDept')}}"><i class="fa fa-circle-o"></i> Data Dept</a></li>
            <li class="{{CH::segment(1,['dataJabatan'])}}"><a href="{{url('dataJabatan')}}"><i class="fa fa-circle-o"></i> 
            Data Jabatan</a></li>
            <li class="{{CH::segment(1,['dataLokasi'])}}"><a href="{{url('dataLokasi')}}"><i class="fa fa-circle-o"></i> Data Lokasi</a></li>
            <li class="{{CH::segment(1,['dataPangkat'])}}"><a href="{{url('dataPangkat')}}"><i class="fa fa-circle-o"></i> Data Pangkat</a></li>
            <li class="{{CH::segment(1,['dataPegawai'])}}"><a href="{{url('dataPegawai')}}"><i class="fa fa-circle-o"></i> Data Pegawai</a></li>
          </ul>
        </li>   -->
        

        
        <li class="header">LABELS</li>       
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        {{$page}}
        <small>{{$subpage}}</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i>{{$page}}</a></li>
        <li class="active">{{$subpage}}</li>
      </ol>
    </section>
    <!-- CUT HERE -->
    @yield('content')
    <!-- CUT HERE -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer noprint">
    <div class="pull-right hidden-xs">
      <b>Version</b> 0.0.1
    </div>
    <strong>Copyleft &copy; 2018 - Polda Bali    
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane" id="control-sidebar-home-tab">
        <h3 class="control-sidebar-heading">Recent Activity</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-birthday-cake bg-red"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                <p>Will be 23 on April 24th</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-user bg-yellow"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>

                <p>New phone +1(800)555-1234</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>

                <p>nora@example.com</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-file-code-o bg-green"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>

                <p>Execution time 5 seconds</p>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

        <h3 class="control-sidebar-heading">Tasks Progress</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Custom Template Design
                <span class="label label-danger pull-right">70%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Update Resume
                <span class="label label-success pull-right">95%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-success" style="width: 95%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Laravel Integration
                <span class="label label-warning pull-right">50%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Back End Framework
                <span class="label label-primary pull-right">68%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

      </div>
      <!-- /.tab-pane -->
      <!-- Stats tab content -->
      <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
      <!-- /.tab-pane -->
      <!-- Settings tab content -->
      <div class="tab-pane" id="control-sidebar-settings-tab">
        <form method="post">
          <h3 class="control-sidebar-heading">General Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Report panel usage
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Some information about this general settings option
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Allow mail redirect
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Other sets of options are available
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Expose author name in posts
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Allow the user to show his name in blog posts
            </p>
          </div>
          <!-- /.form-group -->

          <h3 class="control-sidebar-heading">Chat Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Show me as online
              <input type="checkbox" class="pull-right" checked>
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Turn off notifications
              <input type="checkbox" class="pull-right">
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Delete chat history
              <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
            </label>
          </div>
          <!-- /.form-group -->
        </form>
      </div>
      <!-- /.tab-pane -->
    </div>
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->


<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('public/template/bower_components/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('public/template/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<!-- DataTables -->
<script src="{{ asset('public/template/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('public/template/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<script>
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>
<!-- Auto Currency -->
<script src="{{ asset('public/template/jquery.masknumber.js')}}"></script>
<!-- Morris.js charts -->
<script src="{{ asset('public/template/bower_components/raphael/raphael.min.js')}}"></script>
<script src="{{ asset('public/template/bower_components/morris.js/morris.min.js')}}"></script>
<!-- Sparkline -->
<script src="{{ asset('public/template/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js')}}"></script>
<!-- jvectormap -->
<script src="{{ asset('public/template/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>
<script src="{{ asset('public/template/plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('public/template/bower_components/jquery-knob/dist/jquery.knob.min.js')}}"></script>
<!-- daterangepicker -->
<script src="{{ asset('public/template/bower_components/moment/min/moment.min.js')}}"></script>
<script src="{{ asset('public/template/bower_components/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<!-- datepicker -->
<script src="{{ asset('public/template/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="{{ asset('public/template/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}"></script>
<!-- Slimscroll -->
<script src="{{ asset('public/template/bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
<!-- FastClick -->
<script src="{{ asset('public/template/bower_components/fastclick/lib/fastclick.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('public/template/dist/js/adminlte.min.js')}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('public/template/dist/js/pages/dashboard.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('public/template/dist/js/demo.js')}}"></script>
<!-- DROP DOWN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $('.js-example-basic-single').select2();
});
</script>
</body>
</html>
