@extends('layouts.template')

@section('content')
    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-12 col-xs-6">
         @if (session('status'))
              <div class="alert alert-{{session('status')}}">
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
              <h3 class="box-title">Form Aturan Tunkin</h3>                            
            </div>
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>No</th>
                  <th>Kode Aturan</th>
                  <th>Nama Aturan</th>
                  <th>Status</th>                  
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                  @foreach($dataTunkin as $val)
                    <tr>
                      <td>{{$loop->iteration}}</td>
                      <td>{{$val->kd_aturan}}</td>
                      <td>{{$val->nama_aturan}}</td>
                      <td>
                        @if($val->state == "1")
                          <span class="btn btn-xs btn-success">Aturan Aktif Untuk Tunkin Induk </span>
                        @elseif($val->state == "2")
                          <span class="btn btn-xs btn-default">Aturan Aktif Untuk Tunkin Kekurangan </span>
                        @else
                          <span class="btn btn-xs btn-danger">Aturan Tidak Aktif </span>  
                        @endif
                      </td>                      
                      <td>
                        <form action="{{url('aturanTunkin/'.$val->id)}}" method="POST">
                          {{csrf_field()}}
                          <input type="hidden" name="_method" value="DELETE">
                          <button type="submit" class=" btn btn-danger btn-xs"><i class="fa fa-trash"></i> Hapus</button>
                        </form>
                        <a href="{{url('aturanTunkin/'.$val->id.'/edit')}}" class="btn btn-warning btn-xs"><i class="fa fa-trash"></i> Edit</a>
                        <a href="{{url('aturanTunkin/detail/'.$val->id)}}" class="btn btn-primary btn-xs"> Detail </a>

                        @if($val->state == "0" || $val->state == "2")
                          <a href="{{url('aturanTunkin/aktifkan/'.$val->id)}}" class="btn btn-success btn-xs">Aktifkan Untuk Tunkin Induk</a>
                        @endif
                        @if($val->state == "0" || $val->state == "1")
                          <a href="{{url('aturanTunkin/aktifkanKekurangan/'.$val->id)}}" class="btn btn-default btn-xs">Aktifkan Untuk Tunkin Kekurangan</a>
                        @endif
                      </td>
                    </tr>       
                  @endforeach        
                </tbody>                
              </table>
                             
            </div>           
          </div>
          <!-- end box info -->
        </div>        
      </div>
      <!-- /.row -->
      
    </section>
    <!-- /.content -->
@endsection
