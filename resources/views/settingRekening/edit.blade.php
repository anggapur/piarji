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
              <h3 class="box-title">Form Edit Rekening Pegawai</h3>              
              <!-- /. tools -->
            </div>
            <div class="box-body">
              <form action="{{ route('settingRekening.update',$dataUser->id)}}" method="POST">
                 @method('PUT')
                {{csrf_field()}}
                <div class="form-group">
                  <label>NIP</label>
                  <input type="text" class="form-control" placeholder="Username" value="{{$dataUser->nip}}" disabled>
                </div>
                <div class="form-group">
                  <label>Nama</label>
                  <input type="text" class="form-control" placeholder="Username" value="{{$dataUser->nama}}" disabled>
                </div>
                <div class="form-group">
                  <label>No Rekening</label>
                  <input type="text" name="no_rekening" placeholder="No Rekening" class="form-control" value="{{$dataUser->no_rekening}}">
                </div>
            </div>
            <div class="box-footer clearfix">
              <button type="submit" class="pull-right btn btn-success" id="sendEmail">Update Pegawai
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
    