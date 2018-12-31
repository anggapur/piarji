@extends('layouts.template')

@section('content')
    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-12 col-xs-12">         
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
            <!-- <form method="POST" action="{{route('absensi.store')}}">   -->
              {{csrf_field()}}
            <div class="box-header">              
              <h3 class="box-title">Upload File For Restore</h3>                            
            </div>
            <div class="box-body">    
              <form id="restoreForm" action="{{ route('backupRestore.store')}}" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
               <div class="form-group">
                <label>Upload File</label>
                <input type="file" name="uploadFile" class="form-control" required="required">
               </div>
               <div class="form-group">
                <input type="submit" name="submitUpload" class="btn btn-success" value="Upload To Restore">
               </div>
              </form>
            </div>   
          </div>
          <!-- end box info -->
        </div>        
      </div>
      <!-- /.row -->
      
    </section>
    <div class="bgBlack showWhenLoading"></div>
    <div class="spinner showWhenLoading">
      <h3>Uploading & Restore Data</h3>
      <div class="bounce1"></div>
      <div class="bounce2"></div>
      <div class="bounce3"></div>
    </div>

    <script type="text/javascript">
      $(document).ready(function(){
        $('#restoreForm').submit(function(){
          $('.showWhenLoading').fadeIn("slow");
        });
      });
    </script>
@endsection
