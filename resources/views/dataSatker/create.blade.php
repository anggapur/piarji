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
          @if(session('status'))
            <div class="alert alert-{{session('status')}}">
              {{session('message')}}
            </div>
          @endif
          <div class="box box-info">
            <div class="box-header">              
              <h3 class="box-title">Form Buat Satker</h3>              
              <!-- /. tools -->
            </div>
            <div class="box-body">
              <form action="{{ route('dataSatker.store')}}" method="post">
                {{csrf_field()}}
                <div class="form-group">
                  <label>Kode Satker</label>
                  <input type="text" class="form-control" name="kd_satker" placeholder="Kode Satker" value="{{old('kd_satker')}}" required>
                </div>
                <div class="form-group">
                  <label>Nama Satker</label>
                  <input type="text" class="form-control" name="nm_satker" placeholder="Nama Satker" value="{{old('nm_satker')}}" required>
                </div>
                                      
            </div>
            <div class="box-footer clearfix">
              <button type="submit" class="pull-right btn btn-success" id="sendEmail">Buat Satker
                <i class="fa fa-arrow-circle-right"></i></button>
            </div>
          </div>
          </form>
        </div>        
      </div>
      <!-- /.row -->
      
    </section>
    <!-- /.content -->
@endsection
    