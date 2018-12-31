@extends('layouts.template')

@section('content')
    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-12 col-xs-6">
         @if (session('status'))
              <div class="alert alert-success">
                  {!! session('message') !!}
              </div>
          @endif
          @if ($errors->any())
              <div class="alert alert-danger">
                  <ul>
                      @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                  </ul>
              </div>
          @endif
          <div class="box box-info">
            <div class="box-header">              
              <h3 class="box-title">Form Sinkronisasi Data</h3>                            
            </div>
            <div class="box-body">
              <form action="{{url('sinkronisasiData')}}" method="POST">     
                {{csrf_field()}}
                <div class="form-group">
                  <label>Pilih Data Yang Disinkronisasi</label><br>
                  <input class="" type="checkbox" value="yes" name="dept">Data Departemen<br>
                  <input class="" type="checkbox" value="yes" name="lokasi">Data Lokasi<br>
                  <input class="" type="checkbox" value="yes" name="unit">Data Unit<br>
                  <input class="" type="checkbox" value="yes" name="pangkat">Data Pangkat<br>
                  <input class="" type="checkbox" value="yes" name="gapok">Data Gaji Pokok<br>
                  <input class="" type="checkbox" value="yes" name="pegawai">Data Pegawai<br>
                  <input class="" type="checkbox" value="yes" name="satker">Data Satker<br>
                </div>
                <div class="form-group">
                  <input type="submit" name="submit" value="Sinkronisasi" class="btn btn-success">
                </div>
            </div>           
          </div>
          <!-- end box info -->
        </div>        
      </div>
      <!-- /.row -->
      
    </section>
    <!-- /.content -->
@endsection
