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
              <h3 class="box-title">Form Edit Aturan Tunkin</h3>              
              <!-- /. tools -->
            </div>
            <div class="box-body">
              <form action="{{ route('aturanTunkin.update',$dataTunkin->id)}}" method="post">
                @method('PUT')
                {{csrf_field()}}
                <div class="form-group">
                  <label>Kode Aturan</label>
                  <input type="text" class="form-control" name="kd_aturan" placeholder="Kode Aturan" value="{{$dataTunkin->kd_aturan}}" required>
                </div>
                <div class="form-group">
                  <label>Nama Aturan</label>
                  <input type="text" class="form-control" name="nama_aturan" placeholder="Nama Aturan" value="{{$dataTunkin->nama_aturan}}" required>
                </div>
                <div class="form-group">
                  <label>Aktif/Tidak Aktif</label><br>
                  <input type="radio" name="state" value="1" @if($dataTunkin->state == 1) checked @endif > Aktif Untuk Tunkin Induk<br>
                  <input type="radio" name="state" value="2" @if($dataTunkin->state == 2) checked @endif > Aktif Untuk Tunkin Kekurangan<br>
                  <input type="radio" name="state" value="0" @if($dataTunkin->state == 0) checked @endif > Tidak Aktif <br>
                </div>   
                <hr>
                <button class="btn btn-success btn-xs" type="button" id="tambahSubIndikator">Tambah Kelas Jabatan Dan Tunjangan</button>
                <br>
                <br>       
                <div class="row rowSubIndikator">
                  @php $i = 1; @endphp
                  @foreach(collect($dataTunkin->detailAturanTunkinDetail)->sortBy('kelas_jabatan') as $val)
                  <div class=" col-sm-4" id="col{{$i}}">
                    <div class="form-group">
                      <span class="floatRight"><i class="fa fa-trash" onclick="deleteDiv({{$i}})"></i></span>
                      <label>Kelas Jabatan</label>
                      <input type="number" name="kelas_jabatan[{{$i}}]" class="form-control" placeholder="Kelas Jabatan" required="required" value="{{$val->kelas_jabatan}}">
                      <label style="padding-top: 5px;">Tunjangan</label>
                      <input type="text" name="tunjangan[{{$i++}}]" class="form-control tunjangan" placeholder="Tunjangan" required="required" value="{{CH::currencyIndo($val->tunjangan)}}">
                    </div>
                    <hr>
                  </div>
                  @endforeach
                </div>

            </div>
            <div class="box-footer clearfix">
              <button type="submit" class="pull-right btn btn-success" id="sendEmail">Update Aturan Tunkin
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

        var i = {{$i}};
        $('#tambahSubIndikator').click(function(){
          html = '<div class=" col-sm-4" id="col'+i+'">'+
                      '<div class="form-group">'+
                      '<span class="floatRight"><i class="fa fa-trash" onclick="deleteDiv('+i+')"></i></span>'+
                        '<label>Kelas Jabatan</label>'+
                        '<input type="number" name="kelas_jabatan['+i+']" class="form-control" placeholder="Kelas Jabatan" required="required">'+
                        '<label style="padding-top: 5px;">Tunjangan</label>'+
                        '<input type="text" name="tunjangan['+i+']" class="form-control tunjangan" placeholder="Tunjangan" required="required">'+
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
    