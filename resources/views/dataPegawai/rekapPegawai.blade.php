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
              <h3 class="box-title">Rekap Pegawai</h3>                            
            </div>
            <div class="box-body">
               <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>Kode Satker</th>
                      <th>Nama Satker</th>
                      <th>Jumlah Personil</th>
                    </tr>
                  </thead>  
                  <tbody>
                    @php $jumlah = 0; @endphp
                    @foreach($dataRekap as $val)
                    <tr>
                      <td>{{$val->kd_satker}}</td>
                      <td>{{$val->nm_satker}}</td>
                      <td>{{$val->get_pegawai_count}}</td>
                    </tr>
                    @php $jumlah += $val->get_pegawai_count; @endphp
                    @endforeach
                    <tr>
                      <th colspan="2">Jumlah</th>
                      <th>{{$jumlah}}</th>
                    </tr>
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
