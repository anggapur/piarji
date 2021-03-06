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
          <div class="box box-info noprint" >
            <!-- <form method="POST" action="{{route('absensi.store')}}">   -->
              {{csrf_field()}}
            <div class="box-header">              
              <h3 class="box-title">Per Kelas Jabatan</h3>                            
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
                <div class="form-group @if(Auth::user()->level != 'admin') hide @endif hide">
                  <label>Kode Satker</label>
                  <select class="js-example-basic-single form-control" name="kd_satker">    
                    <option value="">-</option>                
                    @foreach($dataSatker as $val)
                      <option value="{{$val->kd_satker}}">{{$val->kd_satker." - ".$val->nm_satker}}</option>                  
                    @endforeach
                  </select>                 
                </div>              
                <div class="form-group hide">
                  <label>Kategori</label>
                  <select class="js-example-basic-single form-control" name="jenis_pegawai">    
                    <option value="">Polri & PNS</option>                
                    <option value="0">Polri</option>                
                    <option value="1">PNS</option>                
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
              <div id="printArea" class="printArea" style="display: none;overflow-x: scroll;">
                 <div class="headerKU">

                    <div class="leftKU">
                      <div class="logoPolriLaporan"><img src="{{url('public/asset/Logo-POLRI-bw.png')}}"></div>
                      <h5>KEPOLISIAN NEGARA REPUBLIK INDONESIA <br> DAERAH BALI <br> BIDANG KEUANGAN</h5>
                    </div>
                    <div class="rightKU">

                    </div>
                    <div class="clearfix"></div>
                  </div>

                  <div class="judulLaporan">
                    <h5 class="judul">
                    REKAPITULASI   TUNJANGAN KINERJA SESUAI KELAS JABATAN <span class="keanggotaan"></span> T.A <span class="tahun"></span>
                    <br>POLDA BALI
                    </h5>
                  <h5>Bulan : <span class="waktu"></span></h5>
                  </div>                
               <table border="1" cellpadding="10" id="tableLaporan" class="tablePolri">
                 <thead>
                   <tr>
                     <th rowspan="3"> No</th>
                     <th colspan="2"> Kuat Pers</th>
                     <th rowspan="3"> Kelas Jabatan</th>
                     <th colspan="3"> POLRI</th>
                     <th colspan="3"> PNS</th>
                     <th colspan="3"> JUMLAH KESELURUHAN</th>
                   </tr>
                   <tr>
                     <th rowspan="2">POLRI</th>
                     <th rowspan="2">PNS</th>
                     <th rowspan="2">POLRI X INDEX</th>
                     <th rowspan="2">PPH 21</th>
                     <th rowspan="2">BRUTO</th>
                     <th rowspan="2">PNS X INDEX</th>
                     <th rowspan="2">PPH 21</th>
                     <th rowspan="2">BRUTO</th>
                     <th colspan="3">POLRI+PNS</th>
                   </tr>
                   <tr>
                     <th>BERSIH</th>
                     <th>PPH</th>
                     <th>BRUTO</th>
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
                     <th>13</th>
                   </tr>
                 </thead>
                 <tbody>
                   
                 </tbody>
               </table> 

               <hr>

               <div class="headerKU">

                    <div class="leftKU">
                      <div class="logoPolriLaporan"><img src="{{url('public/asset/Logo-POLRI-bw.png')}}"></div>
                      <h5>KEPOLISIAN NEGARA REPUBLIK INDONESIA <br> DAERAH BALI <br> BIDANG KEUANGAN</h5>
                    </div>
                    <div class="rightKU">

                    </div>
                    <div class="clearfix"></div>
                  </div>

                  <div class="judulLaporan">
                    <h5 class="judul">
                    REKAPITULASI   TUNJANGAN KINERJA TIPIDKOR SESUAI KELAS JABATAN <span class="keanggotaan"></span> T.A <span class="tahun"></span>
                    <br>POLDA BALI
                    </h5>
                  <h5>Bulan : <span class="waktu"></span></h5>
                  </div>                
               <table border="1" cellpadding="10" id="tableLaporan" class="tableTipidkor">
                 <thead>
                   <tr>
                     <th rowspan="3"> No</th>
                     <th colspan="2"> Kuat Pers</th>
                     <th rowspan="3"> Kelas Jabatan</th>
                     <th colspan="3"> POLRI</th>
                     <th colspan="3"> PNS</th>
                     <th colspan="3"> JUMLAH KESELURUHAN</th>
                   </tr>
                   <tr>
                     <th rowspan="2">POLRI</th>
                     <th rowspan="2">PNS</th>
                     <th rowspan="2">POLRI X INDEX</th>
                     <th rowspan="2">PPH 21</th>
                     <th rowspan="2">BRUTO</th>
                     <th rowspan="2">PNS X INDEX</th>
                     <th rowspan="2">PPH 21</th>
                     <th rowspan="2">BRUTO</th>
                     <th colspan="3">POLRI+PNS</th>
                   </tr>
                   <tr>
                     <th>BERSIH</th>
                     <th>PPH</th>
                     <th>BRUTO</th>
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
                     <th>13</th>
                   </tr>
                 </thead>
                 <tbody>
                   
                 </tbody>
               </table>                


               <!-- @if($dataTTD->count() != 0)
               <div class="TTDarea row"> 
                <div class="TTD1 col-cs-4">
                  <div class="nilai1 top-20">
                    {{collect($dataTTD)->firstWhere('bagian','1')->nilai1}}
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
                <div class="TTD2 col-cs-4">
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
                <div class="TTD3 col-cs-4">
                   <div class="nilai4">
                    {{collect($dataTTD)->firstWhere('bagian','3')->nilai4}}
                  </div>
                  <div class="nilai1">
                    {{collect($dataTTD)->firstWhere('bagian','3')->nilai1}}
                  </div>
                   @if(collect($dataTTD)->firstWhere('bagian','3')->image != "")
                    <div class="imgWrap">
                    <img class="imageTTD" src="{{url('public/images/'.collect($dataTTD)->firstWhere('bagian','3')->image)}}">
                  </div>
                  @else
                    <div class="ttdImage"></div>
                  @endif
                  <div class="nilai2">
                    <span>{{collect($dataTTD)->firstWhere('bagian','3')->nilai2}}</span>
                  </div>
                  <div class="nilai3">
                    {{collect($dataTTD)->firstWhere('bagian','3')->nilai3}}
                  </div>
                </div>

               </div>
               @endif -->
              </div>             
            </div>   
          </div>
          <!-- end box info -->
        </div>        
      </div>
      <!-- /.row -->
      
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
      //alert(parseInt(1000.4));
      //form bulan tahun
        $('#formBulanTahun').submit(function(e){          
          bulan = $(this).find("select[name='bulan']").val();
          tahun = $(this).find("select[name='tahun']").val();
          satker = $(this).find("select[name='kd_satker']").val();
          jenis_pegawai = $(this).find("select[name='jenis_pegawai']").val();
          
          // alert(satker);
          //ubah nama th
          if(jenis_pegawai == "")
            $('#thPangkatGologan').html('Pangkat / Golongan');
          else if(jenis_pegawai == "0")
            $('#thPangkatGologan').html('Pangkat');
          else if(jenis_pegawai == "1")
            $('#thPangkatGologan').html('Golongan');

          $.ajax({
                type: "POST",                  
                url: "{{route('apiLbrKerja')}}",
                data: 
                { 
                  "_token": "{{ csrf_token() }}",
                  "bulan" : bulan,
                  "tahun" : tahun,
                  "satker" : satker,
                  "jenis_pegawai" : jenis_pegawai,
                },
                success: function(data) {
                  console.log(data.data);
                  $('#printArea').fadeIn("slow");  
                  $('.tahun').html(data.tahun);
                  $('.waktu').html(data.bulan+" "+data.tahun); 
                  printTable(data,"tablePolri");
                }//end success
            });

            $.ajax({
                  type: "POST",                  
                  url: "{{route('apiPerKelasJabatan')}}",
                  data: 
                  { 
                    "_token": "{{ csrf_token() }}",
                    "bulan" : bulan,
                    "tahun" : tahun,
                    "satker" : satker,
                    "jenis_pegawai" : jenis_pegawai,
                  },
                  success: function(data) {
                    console.log(data.data);
                    $('#printArea').fadeIn("slow");  
                    $('.tahun').html(data.tahun);
                    $('.waktu').html(data.bulan+" "+data.tahun); 
                    printTable(data,"tableTipidkor");
                  }//end success
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

          // @todo: for IE parseInt(0.55).toFixed(0) = 0;
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

        function printTable(data,tableClass)
        {
          $('table.'+tableClass+' tbody').empty();                                 
                  //jumlah
                  jumlahAkhir = [];                                                    
                  jumlahAkhir['kuatPersPolri'] = 0;
                  jumlahAkhir['kuatPersPns'] = 0;
                  jumlahAkhir['polriIndex'] = 0;
                  jumlahAkhir['polriPajak'] = 0;
                  jumlahAkhir['polriBruto'] = 0;
                  jumlahAkhir['pnsIndex'] = 0;
                  jumlahAkhir['pnsPajak'] = 0;
                  jumlahAkhir['pnsBruto'] = 0;
                  jumlahAkhir['jumlahSeluruhBersih'] = 0;
                  jumlahAkhir['jumlahSeluruhPajak'] = 0;
                  jumlahAkhir['jumlahSeluruhBruto'] = 0;
                  //loop data
                  datas = [];
                  for(i=16; i >=1 ; i--)
                    {      
                      datas[i] = [];                
                      datas[i]['kuatPersPolri'] = 0;
                      datas[i]['kuatPersPns'] = 0;
                      datas[i]['polriIndex'] = 0;
                      datas[i]['polriPajak'] = 0;
                      datas[i]['polriBruto'] = 0;
                      datas[i]['pnsIndex'] = 0;
                      datas[i]['pnsPajak'] = 0;
                      datas[i]['pnsBruto'] = 0;
                      datas[i]['jumlahSeluruhBersih'] = 0;
                      datas[i]['jumlahSeluruhPajak'] = 0;
                      datas[i]['jumlahSeluruhBruto'] = 0;

                    }
                  $.each(data.data,function(k,v){                    
                    for(i=16; i >=1 ; i--)
                    {
                      
                      //polri                      
                      jumlahOrangPolri = (typeof v.getDataAmprahanPolriGroup[i] === 'undefined') ? 0 : v.getDataAmprahanPolriGroup[i]['jumlahOrang'];                       
                      datas[i]['kuatPersPolri'] += jumlahOrangPolri;
                      //pns
                      jumlahOrangPns = (typeof v.getDataAmprahanPnsGroup[i] === 'undefined') ? 0 : v.getDataAmprahanPnsGroup[i]['jumlahOrang']; 
                      datas[i]['kuatPersPns'] += jumlahOrangPns;
                      datas[i]['kelasJabatan'] = i;

                      jumlahTunjanganPolri = (typeof v.getDataAmprahanPolriGroup[i] === 'undefined') ? 0 : v.getDataAmprahanPolriGroup[i]['jumlahTunjangan']; 
                      datas[i]['polriIndex']+= jumlahTunjanganPolri;

                      jumlahPajakPolri = (typeof v.getDataAmprahanPolriGroup[i] === 'undefined') ? 0 : v.getDataAmprahanPolriGroup[i]['jumlahPajak']; 
                      datas[i]['polriPajak']+= jumlahPajakPolri;

                      brutoPolri =  jumlahTunjanganPolri+jumlahPajakPolri;
                      datas[i]['polriBruto']+= brutoPolri;

                      jumlahTunjanganPns = (typeof v.getDataAmprahanPnsGroup[i] === 'undefined') ? 0 : v.getDataAmprahanPnsGroup[i]['jumlahTunjangan']; 
                      datas[i]['pnsIndex']+= jumlahTunjanganPns;

                      jumlahPajakPns = (typeof v.getDataAmprahanPnsGroup[i] === 'undefined') ? 0 : v.getDataAmprahanPnsGroup[i]['jumlahPajak']; 
                      datas[i]['pnsPajak']+= jumlahPajakPns;

                      brutoPns =  jumlahTunjanganPns+jumlahPajakPns;
                      datas[i]['pnsBruto']+= brutoPns;

                      datas[i]['jumlahSeluruhBersih'] += jumlahTunjanganPolri + jumlahTunjanganPns;
                      datas[i]['jumlahSeluruhPajak'] += jumlahPajakPolri + jumlahPajakPns;
                      datas[i]['jumlahSeluruhBruto'] += brutoPolri + brutoPns;

                      jumlahAkhir['kuatPersPolri']+=jumlahOrangPolri;
                      jumlahAkhir['kuatPersPns'] +=jumlahOrangPns;
                      jumlahAkhir['polriIndex'] +=jumlahTunjanganPolri;
                      jumlahAkhir['polriPajak'] +=jumlahPajakPolri;
                      jumlahAkhir['polriBruto'] +=brutoPolri;
                      jumlahAkhir['pnsIndex'] += jumlahTunjanganPns;
                      jumlahAkhir['pnsPajak'] += jumlahPajakPns;
                      jumlahAkhir['pnsBruto'] += brutoPns;
                      jumlahAkhir['jumlahSeluruhBersih']+=jumlahTunjanganPolri + jumlahTunjanganPns;;
                      jumlahAkhir['jumlahSeluruhPajak']+=jumlahPajakPolri + jumlahPajakPns;;
                      jumlahAkhir['jumlahSeluruhBruto'] +=brutoPolri + brutoPns;

                    }
                  });

                  console.log(datas);
                  console.log(jumlahAkhir);
                   
                  i=1;
                  for(k = 16; k >=1;k--)
                  {                 
                    v = datas[k];   

                      html = "<tr>"+
                                "<td>"+(i++)+"</td>"+
                                "<td>"+v.kuatPersPolri+"</td>"+
                                "<td>"+v.kuatPersPns+"</td>"+
                                "<td>"+v.kelasJabatan+"</td>"+
                                "<td>Rp. "+number_format(v.polriIndex,0,",",".")+"</td>"+
                                "<td>Rp. "+number_format(v.polriPajak,0,",",".")+"</td>"+
                                "<td>Rp. "+number_format(v.polriBruto,0,",",".")+"</td>"+
                                "<td>Rp. "+number_format(v.pnsIndex,0,",",".")+"</td>"+
                                "<td>Rp. "+number_format(v.pnsPajak,0,",",".")+"</td>"+
                                "<td>Rp. "+number_format(v.pnsBruto,0,",",".")+"</td>"+
                                "<td>Rp. "+number_format(v.jumlahSeluruhBersih,0,",",".")+"</td>"+
                                "<td>Rp. "+number_format(v.jumlahSeluruhPajak,0,",",".")+"</td>"+
                                "<td>Rp. "+number_format(v.jumlahSeluruhBruto,0,",",".")+"</td>"+
                              "</tr>";
                      $('table.'+tableClass+' tbody').append(html);
                   } 
                   //akhir
                   v = jumlahAkhir;
                   html = "<tr>"+
                                "<td>Jumlah</td>"+
                                "<td>"+v.kuatPersPolri+"</td>"+
                                "<td>"+v.kuatPersPns+"</td>"+
                                "<td>-</td>"+
                                "<td>Rp. "+number_format(v.polriIndex,0,",",".")+"</td>"+
                                "<td>Rp. "+number_format(v.polriPajak,0,",",".")+"</td>"+
                                "<td>Rp. "+number_format(v.polriBruto,0,",",".")+"</td>"+
                                "<td>Rp. "+number_format(v.pnsIndex,0,",",".")+"</td>"+
                                "<td>Rp. "+number_format(v.pnsPajak,0,",",".")+"</td>"+
                                "<td>Rp. "+number_format(v.pnsBruto,0,",",".")+"</td>"+
                                "<td>Rp. "+number_format(v.jumlahSeluruhBersih,0,",",".")+"</td>"+
                                "<td>Rp. "+number_format(v.jumlahSeluruhPajak,0,",",".")+"</td>"+
                                "<td>Rp. "+number_format(v.jumlahSeluruhBruto,0,",",".")+"</td>"+
                              "</tr>";
                      $('table.'+tableClass+' tbody').append(html);
        }
   </script>
@endsection
