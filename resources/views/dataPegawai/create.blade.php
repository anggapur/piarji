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
              <h3 class="box-title">Form Edit Pegawai</h3>              
              <!-- /. tools -->
            </div>
            <div class="box-body">              
              <form action="{{ route('dataPegawai.store')}}" method="POST">
                 
                {{csrf_field()}}
                <div class="form-group">
                  <label>NIP/NRP</label>
                  <input type="text" class="form-control" name="nip" placeholder="NIP/NRP" value="" >
                </div>
                <div class="form-group">
                  <label>Nama</label>
                  <input type="text" class="form-control" name="nama" placeholder="Nama" value="" required>
                </div>
                <div class="form-group">
                  <label>Kelas Jabatan</label>
                  <select class="form-control" name="kelas_jab" required>
                    <option value="">Pilih</option>
                    @foreach($aturanTunkin->detailAturanTunkinDetail as $value)
                      <option value="{{$value->kelas_jabatan}}" > {{$value->kelas_jabatan}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label>Pangkat</label>
                    <input list="pangkat" name="kd_pangkat" class="form-control" placeholder="Pangkat" value="" required>
                    <datalist id="pangkat">
                      @foreach($pangkat as $val)
                        <option value="{{$val->nm_pangkat2}}">                      
                      @endforeach
                    </datalist>
                </div>
                <div class="form-group">
                  <label>Jabatan</label>
                    <input list="jabatan" name="kd_jab" class="form-control" placeholder="Jabatan" value="" required>
                    <datalist id="jabatan">
                      @foreach($jabatan as $val)
                        <option value="{{$val->nm_jabatan}}">                      
                      @endforeach
                    </datalist>
                </div>
                <div class="form-group">
                  <label>Jenis Kelamin</label><br>
                  <input type="radio" name="jenis_kelamin" value="L" > Laki - Laki <br>
                  <input type="radio" name="jenis_kelamin" value="P" > Perempuan <br>
                </div>
                <div class="form-group">
                  <label>Status</label><br>
                  <input type="radio" name="kawin" value="K"> Kawin <br>
                  <input type="radio" name="kawin" value="TK" > Tidak Kawin <br>
                </div>
                <div class="form-group">        
                  <label>Tanggungan</label>
                  <input type="number" class="form-control" name="tanggungan" placeholder="Tanggungan" value="" required>
                </div>
                <div class="form-group">        
                  <label>Gaji Pokok</label>
                  <input type="text" class="form-control money" name="gapok" placeholder="Gaji Pokok" value="" required>
                </div>
                <div class="form-group">        
                  <label>Tunjangan Struktural Fungsional</label>
                  <input type="text" class="form-control money" name="tunj_strukfung" placeholder="Tunjangan Struktural Fungsional" value="" required>
                </div>
                <div class="form-group">        
                  <label>Tunjangan Lain - Lain</label>
                  <input type="text" class="form-control money" name="tunj_lain" placeholder="Tunjangan Lain - Lain" value="" required>
                </div>
                @if(Auth::user()->level == "admin")
                <div class="form-group">
                  <label>Kode Satker</label>
                  <select class="js-example-basic-single form-control" name="kd_satker" required>     
                  <option value=""> Pilih </option>               
                    @foreach($dataSatker as $val)
                      <option value="{{$val->kd_satker}}" >{{$val->kd_satker." - ".$val->nm_satker}}</option>                                        
                    @endforeach
                  </select>                 
                </div>              
                @endif
            </div>
            <div class="box-footer clearfix">
              <button type="submit" class="pull-right btn btn-success" id="sendEmail">Buat Pegawai Baru
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
        $('.money').maskNumber({integer: true,thousands: '.'});
      });
    </script>
@endsection
    