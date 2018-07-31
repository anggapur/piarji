
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
              <h3 class="box-title">Form Update Kebijakan Absensi</h3>              
              <!-- /. tools -->
            </div>
            <div class="box-body">
              <div class="form-group">
                <label>Keterangan</label>
                <p>
                  G = Gaji<br>
                  H = Hari<br>
                </p>
              </div>
              <hr>
              <form action="{{ route('kebijakanAbsensi.update',Auth::user()->id)}}" method="POST">
                 @method('PUT')
                {{csrf_field()}}
                @foreach($dataKebijakan as $val)
                <div class="form-group">
                  <label>Nama Rumus</label>
                  <textarea class="form-control"  name="nama[{{$val->id}}]" rows="3" required> {!!$val->nama!!} </textarea>
                  <label>Rumus</label>
                  <input type="text" class="form-control"  name="rumus[{{$val->id}}]" value="{{$val->rumus}}" required>
                </div>     
                <hr>   
                @endforeach                              
            </div>
            <div class="box-footer clearfix">
              <button type="submit" class="pull-right btn btn-success" id="updateKebijakan">Update Kebijakan Absensi
                <i class="fa fa-arrow-circle-right"></i></button>
            </div>
          </div>
          </form>
        </div>        
      </div>
      <!-- /.row -->
      
    </section>
    <!-- /.content -->
    <script type="text/javascript">
      $(".form-control").on({
        keydown: function(e) {
          if (e.which === 32)
            return false;
        },
        change: function() {
          this.value = this.value.replace(/\s/g, "");
        }
      });
    </script>
@endsection
    