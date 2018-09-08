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
              <h3 class="box-title">Form Edit User</h3>              
              <!-- /. tools -->
            </div>
            <div class="box-body">
              <form action="{{ route('settingUser.update',$dataUser->id)}}" method="POST">
                 @method('PUT')
                {{csrf_field()}}
                <div class="form-group">
                  <label>Username</label>
                  <input type="text" class="form-control" name="name" placeholder="Username" value="{{$dataUser->name}}" required>
                </div>
                <div class="form-group">
                  <label>Email</label>
                  <input type="email" class="form-control" name="email" placeholder="Email" value="{{$dataUser->email}}" required>
                </div>
                <div class="form-group">
                  <label>Password</label>
                  <input type="password" class="form-control" name="password" placeholder="Password" required>
                </div>
                <div class="form-group">
                  <label>Confirmation Password</label>
                  <input type="password" class="form-control" name="conf_password" placeholder="Confirm Password" required>
                </div>
                <div class="form-group">
                  <label>Kode Satker</label>
                  <select class="js-example-basic-single form-control" name="kd_satker" required>                    
                    @foreach($dataSatker as $val)
                      <option value="{{$val->id}}" {{($val->id == $dataUser->kd_satker) ? "selected" : ""}}>{{$val->kd_satker." - ".$val->nm_satker}}</option>                                        
                    @endforeach
                  </select>                 
                </div>              
            </div>
            <div class="box-footer clearfix">
              <button type="submit" class="pull-right btn btn-success" id="sendEmail">Update User
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
    