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
          @if (session('status'))
              <div class="alert alert-{{session('status')}}">
                  {!! session('message') !!}
              </div>
          @endif
          <div class="box box-info">
            <div class="box-header">              
              <h3 class="box-title">Form Edit Profile</h3>              
              <!-- /. tools -->
            </div>
            <div class="box-body">
              <form action="{{ route('profile.update',Auth::user()->id)}}" method="POST">
                 @method('PUT')
                {{csrf_field()}}
                <div class="form-group">
                  <label>Username</label>
                  <input type="text" class="form-control"  placeholder="Username" value="{{$dataUser->name}}" readonly>
                </div>
                <div class="form-group">
                  <label>Email</label>
                  <input type="email" class="form-control" placeholder="Email" value="{{$dataUser->email}}" readonly>
                </div>
                <div class="form-group">
                  <label>Satker</label>
                  <input type="text" class="form-control" placeholder="Email" value="{{$dataUser->kd_satker.' - '.$dataUser->nm_satker}}" readonly>
                </div>
                 <div class="form-group">
                  <label>Current Password</label>
                  <input type="password" class="form-control" name="old_password" placeholder="Current Password" required>
                </div>
                <div class="form-group">
                  <label>New Password</label>
                  <input type="password" class="form-control" name="new_password" placeholder="New Password" required>
                </div>
                <div class="form-group">
                  <label>Confirmation New Password</label>
                  <input type="password" class="form-control" name="confirm_password" placeholder="Confirm New Password" required>
                </div>                          
            </div>
            <div class="box-footer clearfix">
              <button type="submit" class="pull-right btn btn-success" id="sendEmail">Update Profile
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
    