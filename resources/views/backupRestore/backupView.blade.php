@extends('layouts.template')

@section('content')
    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-12 col-xs-12">         
              <div class="alert alert-success" style="display: none;">
                  Berhasil Simpan Data
              </div>          
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
            <!-- <form method="POST" action="{{route('absensi.store')}}">   -->
              {{csrf_field()}}
            <div class="box-header">              
              <h3 class="box-title">List Backup File</h3>                            
            </div>
            <div class="box-body">    
              <table id="example1" class="display table table-bordered table-striped" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <td>No</td>
                    <td>Tanggal</td>
                    <td>Action</td>
                  </tr>
                </thead>
                <tbody>
                  @foreach($files as $value)
                  <tr>
                    <td>
                      {{$loop->iteration}}
                    </td>
                    <td>
                      @php
                        $file = substr($value,26,19);
                        $date = substr($file,0,10);
                        $date = str_replace('-','/',$date);
                        $time = str_replace('-',':',substr($file,11,5));
                      @endphp
                      <b>{{Carbon\Carbon::parse($date)->format('d F Y')}}</b> <span style="padding-left: 10px;">{{$time}}</span>
                    </td>
                    <td>
                      <a href="{{asset($value)}}" class="btn btn-success btn-xs">Download</a>
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
    
@endsection
