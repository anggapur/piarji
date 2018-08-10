@extends('layouts.template')

@section('content')
    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-12 col-xs-6">
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
              <h3 class="box-title">Form Import Rekening Pegawai</h3>              
              <!-- /. tools -->
            </div>
            <div class="box-body">
              <div class="col-md-12">
                <form class="form-horizontal" role="form" enctype="multipart/form-data" method="POST" action="{{url('settingRekening/importrekening')}}" >
                  {{csrf_field()}}
                     <!--  <div class="form-group">                        
                      <a href="{{url('exportproduk')}}" class="btn btn-success">Export</a>                        
                      </div> -->
                      <div class="form-group">
                          <label for="file" >File</label>                        
                          <input id="file" type="file" class="form-control" name="file">                        
                      </div>
                      <div class="form-group">                         
                          <button type="submit" class="btn btn-primary">Import Data Rekening Pegawai</button>                        
                      </div>
                </form>         
              </div>
            </div>           
          </div>          
        </div>        
      </div>
      <!-- /.row -->
      
    </section>
    <!-- /.content -->
@endsection
    