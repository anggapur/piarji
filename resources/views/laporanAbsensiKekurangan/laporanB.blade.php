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
          <div class="box box-info noprint">
            <!-- <form method="POST" action="{{route('absensi.store')}}">   -->
              {{csrf_field()}}
            <div class="box-header">              
              <h3 class="box-title">Laporan B1 Polri & B2 PNS</h3>                                                    
            </div>
            <div class="box-body">    
              <form class="form-inline" id="formBulanTahun">
                <div class="form-group">
                  <label>Bulan</label>
                  <select class="form-control" name="bulan">
                    {!!CH::printBulan()!!}
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
                <div class="form-group">
                  <label>Kategori</label>
                  <select class="js-example-basic-single form-control" name="jenis_pegawai">    
                    <option value="">Polri & PNS</option>                
                    <option value="0">Polri</option>                
                    <option value="1">PNS</option>                
                    <option value="2">Tipidkor</option>                
                  </select>                 
                </div>  
                <div class="form-group">
                  <input type="submit" name="submitBulanTahun" value="Pilih" class="btn btn-success" id="btnPilih">
                  <button class="btn btn-default" onClick="printReport()">Print</button>
                </div>
              </form>
              </div>
            </div>

            <div class="box " style="border-top:0px;">    
              <div class="box-body">
                <div class="printLaporan" style="display: none;">
                    <div class="headerKU">
                      <div class="leftKU">
                        <div class="logoPolriLaporan"><img src="{{url('public/asset/Logo-POLRI-bw.png')}}"></div>
                        <h5>KEPOLISIAN NEGARA REPUBLIK INDONESIA <br> DAERAH BALI <br> <span class="satkerNama"></span></h5>
                      </div>
                      <div class="rightKU">

                      </div>
                      <div class="clearfix"></div>
                    </div>

                    <div class="judulLaporan">
                      <h5 class="judul">
                      REKAPITULASI DAFTAR PEMBAYARAN TUNJANGAN KINERJA ANGGOTA <span class="keanggotaan"></span>
                      </h5>
                    <h5>Bulan : <span class="waktu"></span></h5>
                    <h5 class="satkerNama"></h5>
                    </div>

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
                   @if(Auth::user()->level == "operator")  
                    <div class="TTDarea row"> 
                <div class="TTD1 col-cs-6">
                  <div class="nilai1 top-20">
                    {!!collect($dataTTD)->firstWhere('bagian','1')->nilai1!!}
                  </div>
                  @if(collect($dataTTD)->firstWhere('bagian','1')->image != "")
                  <div class="imgWrap">
                    <img class="imageTTD" src="{{url('public/images/'.collect($dataTTD)->firstWhere('bagian','1')->image)}}">
                  </div>
                  @else
                    <div class="ttdImage"></div>
                  @endif
                  <div class="nilai2">
                    <span>{{collect($dataTTD)->firstWhere('bagian','1')->nilai2}}</span>
                  </div>
                  <div class="nilai3">
                    {{collect($dataTTD)->firstWhere('bagian','1')->nilai3}}
                  </div>
                </div>
                <div class="TTD3 col-cs-6">
                   <div class="nilai4">
                    {{collect($dataTTD)->firstWhere('bagian','2')->nilai4}}
                  </div>
                  <div class="nilai1">
                    {{collect($dataTTD)->firstWhere('bagian','2')->nilai1}}
                  </div>
                  @if(collect($dataTTD)->firstWhere('bagian','2')->image != "")
                  <div class="imgWrap">
                    <img class="imageTTD" src="{{url('public/images/'.collect($dataTTD)->firstWhere('bagian','2')->image)}}">
                  </div>
                  @else
                    <div class="ttdImage"></div>
                  @endif
                  <div class="nilai2">
                    <span>{{collect($dataTTD)->firstWhere('bagian','2')->nilai2}}</span>
                  </div>
                  <div class="nilai3">
                    {{collect($dataTTD)->firstWhere('bagian','2')->nilai3}}
                  </div>
                </div>
                

               </div> 
               @endif
                </div>         
            </div>   
          </div>
          <!-- end box info -->
        </div>        
      </div>
      <!-- /.row -->
       <div class="bgBlack showWhenLoading"></div>
    <div class="spinner showWhenLoading">
      <h3>Menampilkan Laporan</h3>
      <div class="bounce1"></div>
      <div class="bounce2"></div>
      <div class="bounce3"></div>
    </div>
    </section>
    <script type="text/javascript">
      function printReport()
      {
        
          $('#btnPilih').click();
          setTimeout(function(){
            window.print();
          },1000);
        
          var prtContent = document.getElementById("printArea");
                    
       
          
      }
  </script>
   <script type="text/javascript">
      //form bulan tahun
        $('#formBulanTahun').submit(function(e){     
        $('.showWhenLoading').fadeIn("slow");       
          bulan = $(this).find("select[name='bulan']").val();
          tahun = $(this).find("select[name='tahun']").val();
          satker = $(this).find("select[name='kd_satker']").val();
          jenis_pegawai = $(this).find("select[name='jenis_pegawai']").val();
                    

          $.ajax({
                type: "POST",                  
                url: "{{route('pilihBulanTahunLaporanBKekurangan')}}",
                data: 
                { 
                  "_token": "{{ csrf_token() }}",
                  "bulan" : bulan,
                  "tahun" : tahun,
                  "satker" : satker,
                  "jenis_pegawai" : jenis_pegawai,
                },
                success: function(data) {
                  // alert(data.selectedSatker);
                   $('.satkerNama').html(data.selectedSatker.nm_satker);
                  console.log(data);
                  if(data.status == "nodata")
                  { 
                    $('.showWhenLoading').fadeOut("slow");
                    $('.printLaporan').fadeOut('slow');
                    $('#message').fadeIn("slow").html('Belum Ada Data Absensi');
                    setTimeout(function(){
                      $('#message').fadeOut('slow');
                    },3000)
                  }
                  if(data.dataAbsensi.length == 0)
                  { 
                    $('.showWhenLoading').fadeOut("slow");
                    $('.printLaporan').fadeOut('slow');
                    $('#message').fadeIn("slow").html('Belum Ada Data Absensi');
                    setTimeout(function(){
                      $('#message').fadeOut('slow');
                    },3000)
                  }
                  else if(data.status == "success")
                  {
                    $('.keanggotaan').html(data.keanggotaan);
                    i = 1;
                    $('.printLaporan').fadeIn('slow');
                    $('tbody').empty();

                    $('.waktu').html(data.bulan+" "+data.tahun);

                    console.log(data.formula);
                    formula1 = data.formula[0]['rumus'];
                    formula2 = data.formula[1]['rumus'];
                    formula3 = data.formula[2]['rumus'];
                    formula4 = data.formula[3]['rumus'];
                    absensVal = [];                            

                    //dat aawal nomor kelas jabatan atau yan terbesar
                    awal =  data.tunkin[0];   
                    jml3 = 0;   
                    jml5 = 0;      
                    jml6 = 0;      
                    jml7 = 0;      
                    jml8 = 0;      
                    jml9 = 0;      
                    jml10 = 0;      
                    jml11 = 0;      
                    jml12 = 0;      
                    $.each(data.dataAbsensi,function(k,v){     

                      col5 = (v.count_orang == 0) ? 0 : parseInt(v.tunjangan);
                      col6 = parseInt(v.pph);
                      col7 = parseInt(col5)+parseInt(col6);                      
                      col8 = parseInt(v.jumlahPengurangan);
                      col10 = (v.count_orang == 0) ? 0 : parseInt(v.tunjanganNetto);
                      col11 = parseInt(v.pphNetto);;
                      col12 = parseInt(col10)+parseInt(col11);
                      col9 = col6 - col11;
                      
                      jml3+=v.count_orang;      
                      jml5+=parseInt(col5);      
                      jml6+=parseInt(col6);      
                      jml7+=parseInt(col7);      
                      jml8+= (isNaN(col8)) ?  0 :parseInt(col8);      
                      jml9+= (isNaN(col9)) ?  0 :parseInt(col9);      
                      jml10+= (isNaN(col10)) ?  0 :parseInt(col10);      
                      jml11+= (isNaN(col11)) ?  0 :parseInt(col11);  
                      jml12+= (isNaN(col12)) ?  0 :parseInt(col12);

                       html = '<tr>'+
                               '<td>'+(i++)+'</td>'+                               
                               '<td>'+v.kelas_jab+'</td>'+
                               '<td>'+v.count_orang+'</td>'+
                               '<td>'+number_format(v.indexTunjangan,0,",",".")+'</td>'+
                               '<td>'+number_format(parseInt(col5),0,",",".")+'</td>'+
                               '<td>'+number_format(parseInt(col6),0,",",".")+'</td>'+
                               '<td>'+number_format(parseInt(col7),0,",",".")+'</td>'+
                               '<td>'+number_format(parseInt(col8),0,",",".")+'</td>'+
                               '<td>'+number_format(parseInt(col9),0,",",".")+'</td>'+
                               '<td>'+number_format(parseInt(col10),0,",",".")+'</td>'+
                               '<td>'+number_format(parseInt(col11),0,",",".")+'</td>'+
                               '<td>'+number_format(parseInt(col12),0,",",".")+'</td>'+
                             '</tr>';
                      $('tbody').append(html);
                                            

                    });
                    //footer jumlah
                     html = '<tr>'+
                              '<td colspan="2">Jumlah</td>'+
                              '<td>'+jml3+'</td>'+
                              '<td></td>'+
                              '<td>'+number_format(jml5,0,",",".")+'</td>'+
                              '<td>'+number_format(jml6,0,",",".")+'</td>'+
                              '<td>'+number_format(jml7,0,",",".")+'</td>'+
                              '<td>'+number_format(jml8,0,",",".")+'</td>'+
                              '<td>'+number_format(jml9,0,",",".")+'</td>'+
                              '<td>'+number_format(jml10,0,",",".")+'</td>'+
                              '<td>'+number_format(jml11,0,",",".")+'</td>'+
                              '<td>'+number_format(jml12,0,",",".")+'</td>'+
                             '</tr>';
                             //alert(jml12);
                      $('tbody').append(html);

                       $('.showWhenLoading').fadeOut("slow");
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
