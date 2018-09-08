@extends('layouts.template')

@section('content')
    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-12 col-xs-6">
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
            <div class="box-header">              
              <h3 class="box-title">Form Mutasi Pegawai</h3>              
              <!-- /. tools -->
            </div>
            <div class="box-body">
              <form action="{{ route('mutasiSetting.store')}}" method="post">
                {{csrf_field()}}
                <div class="form-group">
                  <label>Dikirin Ke</label>
                  <br>
                  <input type="radio" name="mutasi_ke" value="dalam" checked>Masih Di Polda Bali<br>
                  <input type="radio" name="mutasi_ke" value="keluar">Keluar Polda Bali
                </div>
                <div class="form-group dalam keluar">
                  <label>Nama Pegawai</label>
                  <select class="js-example-basic-single form-control" name="nip" required>                    
                    <option value="">-</option>
                    @foreach($dataPegawai as $val)
                      <option value="{{$val->nip}}">{{$val->nip." - ".$val->nama}}</option>                                        
                    @endforeach
                  </select>                 
                </div>          
                <div class="form-group dalam keluar">
                  <label>Dari Satker</label>
                  <input type="text" class="form-control" readonly="readonly" value="{{CH::getSatker(Auth::user()->kd_satker)}}">
                </div>
                <div class="form-group dalam">
                  <label>Dikirim ke Satker</label>
                  <select class="js-example-basic-single form-control" name="ke_satker" required>                    
                    <option value="">-</option>
                    @foreach($dataSatker as $val)
                      <option value="{{$val->kd_satker}}">{{$val->kd_satker." - ".$val->nm_satker}}</option>                                        
                    @endforeach
                  </select>                 
                </div>                  
                <div class="form-group dalam keluar">
                  <label>Bulan Keluar</label>
                  <select class="form-control" name="bulan_keluar" required="required">
                    <option value="">-</option>
                    <option value="1">Januari</option>
                    <option value="2">February</option>
                    <option value="3">Maret</option>
                    <option value="4">April</option>
                    <option value="5">Mei</option>
                    <option value="6">Juni</option>
                    <option value="7">Juli</option>
                    <option value="8">Agustus</option>
                    <option value="9">September</option>
                    <option value="10">Oktober</option>
                    <option value="11">November</option>
                    <option value="12">Desember</option>
                  </select>
                </div>
                <div class="form-group dalam keluar">
                  <label>Tahun Keluar</label>
                  <select class="form-control" name="tahun_keluar" required="required">
                    <option value="">-</option>
                    @for($i = $tahunTerkecil; $i <= date('Y')+1 ; $i++)
                      <option value="{{$i}}">{{$i}}</option>
                    @endfor
                  </select>
                </div>            
            </div>
            <div class="box-footer clearfix">
              <button type="submit" class="pull-right btn btn-success" id="sendEmail">Mutasi
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

        $('input[name="mutasi_ke"]').click(function(){
          kelas = $(this).val();
          if(kelas == "dalam")
            kelasOposite = "keluar";
          else
            kelasOposite = "dalam";
          
          $('.'+kelasOposite).fadeOut('slow',function(){
            $('.'+kelas).fadeIn('slow');
          });
          
          
        });
      });
    </script>
@endsection
    