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
              <h3 class="box-title">User</h3>                            
            </div>
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>No</th>
                  <th>Username</th>
                  <th>Email</th>
                  <th>Satker</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                  @foreach($dataUser as $val)
                    <tr>
                      <td>{{$loop->iteration}}</td>
                      <td>{{$val->name}}</td>
                      <td>{{$val->email}}</td>
                      <td>{{$val->kd_satker." - ".$val->nm_satker}}</td>
                      <td>
                        <form action="{{url('settingUser/'.$val->id)}}" method="POST">
                          {{csrf_field()}}
                          <input type="hidden" name="_method" value="DELETE">
                          <button type="submit" class=" btn btn-danger btn-xs"><i class="fa fa-trash"></i> Hapus</button>
                        </form>
                        <a href="{{url('settingUser/'.$val->id.'/edit')}}" class="btn btn-warning btn-xs"><i class="fa fa-trash"></i> Edit</a>
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
