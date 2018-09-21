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
          @if(session('status'))
            <div class="alert alert-{{session('status')}}">
              {{session('message')}}
            </div>
          @endif
          <div class="box box-info">
            <div class="box-header">              
              <h3 class="box-title">Form Buat Satker</h3>              
              <!-- /. tools -->
            </div>
            <div class="box-body">
              <form action="{{ route('dataSatker.store')}}" method="post">
                {{csrf_field()}}
                <div class="form-group">
                  <label>Kode Satker</label>
                  <input type="text" class="form-control" name="kd_satker" placeholder="Kode Satker" value="{{old('kd_satker')}}" required>
                </div>
                <div class="form-group">
                  <label>Nama Satker</label>
                  <input type="text" class="form-control" name="nm_satker" placeholder="Nama Satker" value="{{old('nm_satker')}}" required>
                </div>

                <hr>
                <button class="btn btn-success btn-xs" type="button" id="tambahSubIndikator">Tambah Anak Satker</button>
                <br>
                <br>       
                <div class="row rowSubIndikator">
                  <div class=" col-sm-4" id="col1">
                    <div class="form-group">
                      <span class="floatRight"><i class="fa fa-trash" onclick="deleteDiv(1)"></i></span>
                      <label>Kode Anak Satker</label>
                      <input type="text" name="kd_anak_satker[1]" class="form-control" placeholder="Kode Anak Satker" required="required">                      
                      <label>Nama Anak Satker</label>
                      <input type="text" name="nm_anak_satker[1]" class="form-control" placeholder="Nama Anak Satker" required="required">                      
                    </div>
                    <hr>
                  </div>
                </div>

                                      
            </div>
            <div class="box-footer clearfix">
              <button type="submit" class="pull-right btn btn-success" id="sendEmail">Buat Satker
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
      $(document).ready(function(){
        $('.tunjangan').maskNumber({integer: true,thousands: '.'});

        var i = 2;
        $('#tambahSubIndikator').click(function(){
          html = '<div class=" col-sm-4" id="col'+i+'">'+
                      '<div class="form-group">'+
                      '<span class="floatRight"><i class="fa fa-trash" onclick="deleteDiv('+i+')"></i></span>'+
                        '<label>Kode Anak Satker</label>'+
                        '<input type="text" name="kd_anak_satker['+i+']" class="form-control" placeholder="Kode Anak Satker" required="required">'+
                        '<label style="padding-top: 5px;">Nama Anak Satker</label>'+
                        '<input type="text" name="nm_anak_satker['+i+']" class="form-control" placeholder="Nama Anak Satker" required="required">'+
                      '</div><hr>'+
                    '</div>';
          $('.rowSubIndikator').append(html);
          i++;
          $('.tunjangan').maskNumber({integer: true,thousands: '.'});

        });
      });

      // alert(number_format(10000,0,',','.'));
      function deleteDiv(i)
      {
        $('#col'+i).remove();
      }
      
    </script>
@endsection
    