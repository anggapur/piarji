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
              <form action="{{ route('dataPegawai.update',$dataPegawai->id)}}" method="POST">
                 @method('PUT')
                {{csrf_field()}}
                <div class="form-group">
                  <label>NIP/NRP</label>
                  <input type="text" class="form-control" name="nip" placeholder="NIP/NRP" value="{{$dataPegawai->nip}}" readonly>
                </div>
                <div class="form-group">
                  <label>Nama</label>
                  <input type="text" class="form-control" name="nama" placeholder="Nama" value="{{$dataPegawai->nama}}" required>
                </div>
                <div class="form-group">
                  <label>Kelas Jabatan</label>
                  <select class="form-control" name="kelas_jab" required>
                    @foreach($aturanTunkin->detailAturanTunkinDetail as $value)
                      <option value="{{$value->kelas_jabatan}}" @if($dataPegawai->kelas_jab == $value->kelas_jabatan) selected @endif > {{$value->kelas_jabatan}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label>Pangkat</label>
                    <input list="pangkat" name="kd_pangkat" class="form-control" placeholder="Pangkat" value="{{$dataPegawai->nm_pangkat2}}" required>
                    <datalist id="pangkat">
                      @foreach($pangkat as $val)
                        <option value="{{$val->nm_pangkat2}}">                      
                      @endforeach
                    </datalist>
                </div>
                <div class="form-group">
                  <label>Jabatan</label>
                    <input list="jabatan" name="kd_jab" class="form-control" placeholder="Jabatan" value="{{$dataPegawai->nm_jabatan}}" required>
                    <datalist id="jabatan">
                      @foreach($jabatan as $val)
                        <option value="{{$val->nm_jabatan}}">                      
                      @endforeach
                    </datalist>
                </div>
                <div class="form-group">
                  <label>Status Keaktifan</label><br>
                  <input type="radio" name="status_aktif" value="1" @if($dataPegawai->status_aktif == "1") checked @endif> Aktif <br>
                  <input type="radio" name="status_aktif" value="0" @if($dataPegawai->status_aktif == "0") checked @endif> Non-Aktif<br>
                </div>
                <div class="form-group">
                  <label>Jenis Kelamin</label><br>
                  <input type="radio" name="jenis_kelamin" value="L" @if($dataPegawai->jenis_kelamin == "L") checked @endif> Laki - Laki <br>
                  <input type="radio" name="jenis_kelamin" value="P" @if($dataPegawai->jenis_kelamin == "P") checked @endif> Perempuan <br>
                </div>
                <div class="form-group">
                  <label>Status</label><br>
                  <input type="radio" name="kawin" value="K" @if($dataPegawai->kawin == "K") checked @endif> Kawin <br>
                  <input type="radio" name="kawin" value="TK" @if($dataPegawai->kawin == "TK") checked @endif> Tidak Kawin <br>
                </div>
                <div class="form-group">        
                  <label>Tanggungan</label>
                  <input type="number" class="form-control" name="tanggungan" placeholder="Tanggungan" value="{{$dataPegawai->tanggungan}}" required>
                </div>
                <div class="form-group">        
                  <label>Gaji Pokok</label>
                  <input type="text" class="form-control money" name="gapok" placeholder="Gaji Pokok" value="{{CH::currencyIndo($dataPegawai->gapok)}}" required>
                </div>
                <div class="form-group">        
                  <label>Tunjangan Struktural Fungsional</label>
                  <input type="text" class="form-control money" name="tunj_strukfung" placeholder="Tunjangan Struktural Fungsional" value="{{CH::currencyIndo($dataPegawai->tunj_strukfung)}}" required>
                </div>
                <div class="form-group">        
                  <label>Tunjangan Lain - Lain</label>
                  <input type="text" class="form-control money" name="tunj_lain" placeholder="Tunjangan Lain - Lain" value="{{CH::currencyIndo($dataPegawai->tunj_lain)}}" required>
                </div>
                <div class="form-group">        
                  <label>No Rekening</label>
                  <input type="text" class="form-control " name="no_rekening" placeholder="No Rekening" value="{{$dataPegawai->no_rekening}}" required>
                </div>
                @if(Auth::user()->level == "admin")
                <div class="form-group">
                  <label>Kode Satker</label>
                  <select class="js-example-basic-single form-control" name="kd_satker" required>                    
                    @foreach($dataSatker as $val)
                      <option value="{{$val->kd_satker}}" {{($val->kd_satker == $dataPegawai->kd_satker) ? "selected" : ""}}>{{$val->kd_satker." - ".$val->nm_satker}}</option>                                        
                    @endforeach
                  </select>                 
                </div>              
                @endif
            </div>
            <div class="box-footer clearfix">
              <button type="submit" class="pull-right btn btn-success" id="sendEmail">Update Pegawai
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
    