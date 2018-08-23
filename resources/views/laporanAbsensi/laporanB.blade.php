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
                <div class="form-group @if(Auth::user()->level != 'admin') hide @endif">
                  <label>Kode Satker</label>
                  <select class="js-example-basic-single form-control" name="kd_satker">    
                    <option value="">-</option>                
                    @foreach($dataSatker as $val)
                      <option value="{{$val->kd_satker}}">{{$val->kd_satker." - ".$val->nm_satker}}</option>                  
                    @endforeach
                  </select>                 
                </div>              
                <div class="form-group @if(Auth::user()->level != 'admin') hide @endif">
                  <label>Kategori</label>
                  <select class="js-example-basic-single form-control" name="jenis_pegawai">    
                    <option value="">Polri & PNS</option>                
                    <option value="0">Polri</option>                
                    <option value="1">PNS</option>                
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
                     <th rowspan="2">Kelas Jabatan</th>
                     <th rowspan="2">Jumlah Penerima (Org)</th>
                     <th rowspan="2">Indek Tunjangan Kinerja (Rp)</th>
                     <th rowspan="2">Jumlah (Rp) (3x4)</th>
                     <th rowspan="2">Tunjangan PPh21 (Rp)</th>
                     <th rowspan="2">Jumlah Bruto (Rp) (5+6)</th>
                     <th colspan="2">Pengurangan</th>
                     <th colspan="2">Jumlah Netto</th>
                     <th rowspan="2">Jumlah Bruto(10+11)</th>
                   </tr>                  
                   <tr>
                     <th>Tunjangan Kinerja</th>
                     <th>PPH 21</th>
                     <th>TUNJKINERJA <br>(5-8)</th>
                     <th>PPH 21 <br>(6-9)</th>
                   </tr>                 
                    <tr>
                     <th>1</th>
                     <th>2</th>
                     <th>3</th>
                     <th>4</th>
                     <th>5</th>
                     <th>6</th>
                     <th>7</th>
                     <th>8</th>
                     <th>9</th>
                     <th>10</th>
                     <th>11</th>
                     <th>12</th>                     
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
          satker = $(this).find("select[name='kd_satker']").val();
          jenis_pegawai = $(this).find("select[name='jenis_pegawai']").val();
                    

          $.ajax({
                type: "POST",                  
                url: "{{route('pilihBulanTahunLaporanB')}}",
                data: 
                { 
                  "_token": "{{ csrf_token() }}",
                  "bulan" : bulan,
                  "tahun" : tahun,
                  "satker" : satker,
                  "jenis_pegawai" : jenis_pegawai,
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
                  if(data.dataAbsensi.length == 0)
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

                    console.log(data.formula);
                    formula1 = data.formula[0]['rumus'];
                    formula2 = data.formula[1]['rumus'];
                    formula3 = data.formula[2]['rumus'];
                    formula4 = data.formula[3]['rumus'];
                    absensVal = [];                            

                    //dat aawal nomor kelas jabatan atau yan terbesar
                    awal =  data.tunkin[0];            
                    $.each(data.dataAbsensi,function(k,v){     
                      
                      col5 = (v.tunjangan*v.countKelasJab);
                      col6 = 100000*v.countKelasJab;
                      col7 = col5+col6;                      
                      col8 = 0;
                      col9 = 0;
                      col10 = col5-col8;
                      col11 = col6-col9;
                      col12 = col10+col11;
                    

                      html = '<tr>'+
                               '<td>'+(i++)+'</td>'+                               
                               '<td>'+v.kelas_jab+'</td>'+
                               '<td>'+v.countKelasJab+'</td>'+
                               '<td>'+number_format(v.tunjangan,0,",",".")+'</td>'+
                               '<td>'+number_format(col5,0,",",".")+'</td>'+
                               '<td>'+number_format(col6,0,",",".")+'</td>'+
                               '<td>'+number_format(col7,0,",",".")+'</td>'+
                               '<td>'+col8+'</td>'+
                               '<td>'+col9+'</td>'+
                               '<td>'+number_format(col10,0,",",".")+'</td>'+
                               '<td>'+number_format(col11,0,",",".")+'</td>'+
                               '<td>'+number_format(col12,0,",",".")+'</td>'+
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


        function absensiFormulaMath(formula,tunjangan,absensi)
        {
          absensiVal = formula.replace('G',tunjangan);
          absensiVal = absensiVal.replace('H',absensi);
          absensiVal = eval(absensiVal);
          return absensiVal;
        }
        function getSum(total, num) {
            return total + num;
        }
   </script>
@endsection
