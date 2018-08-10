@extends('layouts.template')

@section('content')
    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-12 col-xs-12">         
              <div class="alert alert-success" style="display: none;" id="message">
                  Berhasil Simpan Data
              </div>          
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
              <h3 class="box-title">Form Absensi</h3>                            
            </div>
            <div class="box-body">    
              <form class="form-inline" id="formBulanTahun">
                <div class="form-group">
                  <label>Bulan</label>
                  <select class="form-control" name="bulan">
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
                <div class="form-group">
                  <label>Tahun</label>
                  <select class="form-control" name="tahun">
                    @for($i = $tahunTerkecil; $i <= date('Y')+1 ; $i++)
                      <option value="{{$i}}">{{$i}}</option>
                    @endfor
                  </select>
                </div>
                <div class="form-group">
                  <input type="submit" name="submitBulanTahun" value="Pilih" class="btn btn-success" id="btnPilih">
                </div>
              </form>
              <hr>

               <table border="1" cellpadding="10" id="tableLaporan">
                 <thead>
                  <tr>
                     <th rowspan="2">No</th>
                     <th rowspan="2">Nama</th>
                     <th rowspan="2">Pangkat</th>
                     <th rowspan="2">NRP</th>
                     <th rowspan="2">Jabatan</th>
                     <th rowspan="2">Kelas Jabatan</th>
                     <th rowspan="2">T. Kinerja</th>
                     <th colspan="2" class="w100">{{collect($aturan_absensi)->firstWhere('id','1')->nama}}</th>                                          
                     <th colspan="2" class="w100">{{collect($aturan_absensi)->firstWhere('id','2')->nama}}</th>                     
                     <th colspan="2" class="w100">{{collect($aturan_absensi)->firstWhere('id','3')->nama}}</th>                     
                     <th colspan="2" class="w100">{{collect($aturan_absensi)->firstWhere('id','4')->nama}}</th>
                     <th rowspan="2" class="w50">Jumlah Pengurangan</th>                     
                     <th rowspan="2" class="w50">Tunjangan Yang Diterima</th>
                     <th rowspan="2" class="w50">T.PPH21</th>
                     <th rowspan="2" class="w50">Terima Bruto</th>
                     <th rowspan="2" class="w50">Potongan<br>PPH-21</th>
                     <th rowspan="2" class="w50">T.Yang Dibayar</th>
                     <th rowspan="2" class="w50">Rekening</th>

                   </tr>
                   <tr>                   
                     <th>Hari</th>
                     <th>Rp</th>
                     <th>Hari</th>
                     <th>Rp</th>
                     <th>Hari</th>
                     <th>Rp</th>
                     <th>Hari</th>
                     <th>Rp</th>
                   </tr>
                 </thead>
                 <tbody>
                   
                 </tbody>
               </table>               
            </div>   
          </div>
          <!-- end box info -->
        </div>        
      </div>
      <!-- /.row -->
      
    </section>
    
   <script type="text/javascript">
      //form bulan tahun
        $('#formBulanTahun').submit(function(e){          
          bulan = $(this).find("select[name='bulan']").val();
          tahun = $(this).find("select[name='tahun']").val();
          
          $.ajax({
                type: "POST",                  
                url: "{{route('pilihBulanTahunLaporan')}}",
                data: 
                { 
                  "_token": "{{ csrf_token() }}",
                  "bulan" : bulan,
                  "tahun" : tahun,
                },
                success: function(data) {
                  console.log(data);
                  if(data.status == "nodata")
                  { 
                    $('table').fadeOut('slow');
                    $('#message').fadeIn("slow").html('Belum Ada Data Absensi');
                    setTimeout(function(){
                      $('#message').fadeOut('slow');
                    },3000)
                  }
                  else if(data.status == "success")
                  {
                    i = 1;
                    $('table').fadeIn('slow');
                    $('tbody').empty();
                    $.each(data.dataAbsensi,function(k,v){
                      html = '<tr>'+
                               '<td>'+(i++)+'</td>'+
                               '<td>'+v.nama+'</td>'+
                               '<td>'+v.nm_pangkat1+'</td>'+
                               '<td>'+v.nip+'</td>'+
                               '<td>'+v.nm_jabatan+'</td>'+
                               '<td>'+v.kelas_jab+'</td>'+
                               '<td>'+number_format(v.tunjangan,0,",",".")+'</td>'+
                               '<td>'+v.absensi1+'</td>'+
                               '<td>-</td>'+
                               '<td>'+v.absensi2+'</td>'+
                               '<td>-</td>'+
                               '<td>'+v.absensi3+'</td>'+
                               '<td>-</td>'+
                               '<td>'+v.absensi4+'</td>'+
                               '<td>-</td>'+
                               '<td>-</td>'+
                               '<td>-</td>'+
                               '<td>-</td>'+
                               '<td>-</td>'+
                               '<td>-</td>'+
                               '<td>-</td>'+
                               '<td>'+v.no_rekening+'</td>'+
                             '</tr>';
                      $('tbody').append(html);
                    });
                  }
                }
            });
          e.preventDefault();
        });

        function number_format (number, decimals, decPoint, thousandsSep) { 

          number = (number + '').replace(/[^0-9+\-Ee.]/g, '')
          var n = !isFinite(+number) ? 0 : +number
          var prec = !isFinite(+decimals) ? 0 : Math.abs(decimals)
          var sep = (typeof thousandsSep === 'undefined') ? ',' : thousandsSep
          var dec = (typeof decPoint === 'undefined') ? '.' : decPoint
          var s = ''

          var toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec)
            return '' + (Math.round(n * k) / k)
              .toFixed(prec)
          }

          // @todo: for IE parseFloat(0.55).toFixed(0) = 0;
          s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.')
          if (s[0].length > 3) {
            s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep)
          }
          if ((s[1] || '').length < prec) {
            s[1] = s[1] || ''
            s[1] += new Array(prec - s[1].length + 1).join('0')
          }

          return s.join(dec)
        }
   </script>
@endsection
