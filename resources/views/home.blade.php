@extends('layouts.template')

@section('content')
    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>{{$jumlahPegawai}}</h3>

              <p>Pegawai</p>
            </div>
            <div class="icon">
              <i class="fa fa-users"></i>
            </div>
            <a href="{{url('dataPegawai')}}" class="small-box-footer">Lihat  <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

        @if(Auth::user()->level == "admin")
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>{{$jumlahOperator}}</h3>

              <p>Operator</p>
            </div>
            <div class="icon">
              <i class="fa fa-user"></i>
            </div>
            <a href="{{url('settingUser')}}" class="small-box-footer">Lihat  <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        @endif
        
        <!-- ./col -->
      </div>
      <!-- /.row -->
      
    </section>
    <!-- /.content -->
@endsection
    