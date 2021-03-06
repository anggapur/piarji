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
              <h3 class="box-title">Daftar Mutasi</h3>                            
            </div>
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>No</th>
                  <th>NIP</th>
                  <th>Nama</th>
                  <th>Ke Satker</th>
                  <th>Ke Anak Satker</th>
                  <th>Waktu Keluar</th>
                  <th>Status Terima</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                  @foreach($dataMutasi as $val)    
                    <tr>
                      <td>{{$loop->iteration}}</td>
                      <td>{{$val->nip}}</td>
                      <td>{{$val->nama}}</td>
                      <td>
                        @if($val->ke_satker !== "out")
                          {{$val->ke_satker}} - {{$val->nm_satker}}
                        @else
                          <span class="label label-danger">Keluar Polda</span>
                        @endif
                      </td>
                      <td>
                        @if($val->ke_satker !== "out")
                          {{$val->ke_anak_satker}} - {{$val->nm_anak_satker}}
                        @else
                          <span class="label label-danger">-</span>
                        @endif
                      </td>
                      <td>{{$bulan[$val->bulan_keluar]}} {{$val->tahun_keluar}}</td>
                      <td>
                        @if($val->ke_satker !== "out")
                          @if($val->status_terima == 0)
                            <span class="label label-warning">Belum Diterima</span>
                          @elseif($val->status_terima == 1)
                            <span class="label label-success">Sudah Diterima - 
                            {{$bulan[$val->bulan_diterima]}} {{$val->tahun_diterima}}</span>
                          @endif
                        @else
                          -
                        @endif
                      </td>
                      <td>
                        @if($val->ke_satker !== "out")
                          @if($val->status_terima == 0)
                             <form action="{{url('mutasiSetting/'.$val->id)}}" method="POST">
                              {{csrf_field()}}
                              <input type="hidden" name="_method" value="DELETE">
                              <button type="submit" class=" btn btn-danger btn-xs"><i class="fa fa-trash"></i> Batalkan</button>
                            </form>
                          @elseif($val->status_terima == 1)
                            -                            
                          @endif
                        @else
                           <form action="{{url('mutasiSetting/'.$val->id)}}" method="POST">
                              {{csrf_field()}}
                              <input type="hidden" name="_method" value="DELETE">
                              <button type="submit" class=" btn btn-danger btn-xs"><i class="fa fa-trash"></i> Batalkan</button>
                            </form>
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
