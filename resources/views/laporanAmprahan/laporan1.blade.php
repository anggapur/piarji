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
              <h3 class="box-title">Laporan Permintaan Tunkin</h3>                            
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
                <div class="form-group ">
                  <label>Kategori</label>
                  <select class="js-example-basic-single form-control" name="jenis_pegawai">    
                   {!!CH::printOptionJenisPegawai()!!}               
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
              <div id="printArea" class="printArea" style="display: none;">
                 <div class="headerKU">

                    <div class="leftKU">
                      <div class="logoPolriLaporan"><img src="{{url('public/asset/Logo-POLRI-bw.png')}}"></div>
                      <h5>KEPOLISIAN NEGARA REPUBLIK INDONESIA <br> DAERAH BALI <br> <span class="satkerName"></span></h5>
                    </div>
                    <div class="rightKU">

                    </div>
                    <div class="clearfix"></div>
                  </div>

                  <div class="judulLaporan">
                    <h5 class="judul">
                    DAFTAR PERMINTAAN TUNJANGAN KINERJA <span class="keanggotaan"></span> T.A <span class="tahun"></span>
                    </h5>
                  <h5>Bulan : <span class="waktu"></span></h5>
                   <h5 class="satkerName"></h5>
                  </div>
               <table border="1" cellpadding="10" id="tableLaporan">
                 <thead>
                  <tr>
                     <th rowspan="2">No</th>
                     <th rowspan="2">Nama</th>
                     <th rowspan="2" id="thPangkatGologan">Pangkat / Golongan</th>
                     <th rowspan="2">NRP</th>
                     <th rowspan="2">Jabatan</th>
                     <th rowspan="2">Kelas Jabatan</th>
                     <th rowspan="2">T. Kinerja</th>
                     <th rowspan="2">PPH 21</th>
                     <th rowspan="2">Bruto</th>
                     
                     <th rowspan="2">Status</th>
                                         
                   </tr>                  
                   
                 </thead>
                 <tbody>
                   
                 </tbody>
               </table> 
               @if($dataTTD->count() != 0)
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
               @endif
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
          
          //ubah nama th
          if(jenis_pegawai == "")
            $('#thPangkatGologan').html('Pangkat / Golongan');
          else if(jenis_pegawai == "0")
            $('#thPangkatGologan').html('Pangkat');
          else if(jenis_pegawai == "1")
            $('#thPangkatGologan').html('Golongan');

          $.ajax({
                type: "POST",                  
                url: "{{route('pilihBulanTahunLaporanPermintaanTunkin')}}",
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
                    $('#printArea').fadeOut('slow');
                    $('#message').fadeIn("slow").html('Belum Ada Data Absensi');
                    setTimeout(function(){
                      $('#message').fadeOut('slow');
                    },3000)
                  }
                  if(data.dataAbsensi.length == 0)
                  { 
                    $('#printArea').fadeOut('slow');
                    $('#message').fadeIn("slow").html('Belum Ada Data Absensi');
                    setTimeout(function(){
                      $('#message').fadeOut('slow');
                    },3000)
                  }
                  else if(data.status == "success")
                  {
                    $('.satkerName').html(data.selectedSatker.nm_satker);
                    $('.keanggotaan').html(data.keanggotaan);
                    i = 1;
                    $('#printArea').fadeIn('slow');
                    $('tbody').empty();

                    $('.waktu').html(data.bulan+" "+data.tahun);
                    $('.tahun').html(data.tahun);

                    console.log(data.formula);
                    formula1 = data.formula[0]['rumus'];
                    formula2 = data.formula[1]['rumus'];
                    formula3 = data.formula[2]['rumus'];
                    formula4 = data.formula[3]['rumus'];
                    absensVal = [];
                    kodeSatker = "0";
                    kodeAnakSatker = "0";
                    awal = true;
                    awal2 = true;
                    tunjanganKinerjaTotal = 0;
                    absensi1total = 0;
                    absensi2total = 0;
                    absensi3total = 0;
                    absensi4total = 0;
                    uang1total = 0;
                    uang2total = 0;
                    uang3total = 0;
                    uang4total = 0;
                    jumlahPenguranganTotal = 0;
                    tunjanganYangDiterimaTotal = 0
                    tPPH21Total =0;
                    terimaBrutoTotal =0;
                    potonganPPH21 = 0;
                    yangDibayarTotal = 0;   
                    jumlahPajak = 0;                 

                    console.log('KKK:'+kodeSatker);
                    $.each(data.dataAbsensi,function(k,v){                      
                      absensVal[1] = parseInt(absensiFormulaMath(formula1,parseInt(v.tunjangan),v.absensi1));
                      absensVal[2] = parseInt(absensiFormulaMath(formula2,parseInt(v.tunjangan),v.absensi2));
                      absensVal[3] = parseInt(absensiFormulaMath(formula3,parseInt(v.tunjangan),v.absensi3));
                      absensVal[4] = parseInt(absensiFormulaMath(formula4,parseInt(v.tunjangan),v.absensi4));
                      jumlahPengurangan = parseInt(absensVal.reduce(getSum));
                      yangDiterima = parseInt(parseInt(v.tunjangan)-parseInt(jumlahPengurangan));
                      tPPH21 = parseInt(v.pajak);
                      terimaBruto = parseInt(parseInt(yangDiterima)+parseInt(tPPH21));                      

                      if(kodeSatker !== v.kd_satker_saat_amprah)
                      {
                        if(awal == true)
                        {
                          awal = false;
                        }
                        else
                        {
                          //insert jumlah
                          html = '<tr><td colspan="6">Jumlah</td>'+
                                  '<td>'+number_format(tunjanganKinerjaTotal,0,",",".")+'</td>'+
                                  '<td>'+absensi1total+'</td>'+
                                  '<td>'+number_format(uang1total,0,",",".")+'</td>'+
                                  '<td>'+absensi2total+'</td>'+
                                  '<td>'+number_format(uang2total,0,",",".")+'</td>'+
                                  '<td>'+absensi3total+'</td>'+
                                  '<td>'+number_format(uang3total,0,",",".")+'</td>'+
                                  '<td>'+absensi4total+'</td>'+
                                  '<td>'+number_format(uang4total,0,",",".")+'</td>'+
                                  '<td>'+number_format(jumlahPenguranganTotal,0,",",".")+'</td>'+
                                  '<td>'+number_format(tunjanganYangDiterimaTotal,0,",",".")+'</td>'+
                                  '<td>'+number_format(tPPH21Total,0,",",".")+'</td>'+
                                  '<td>'+number_format(terimaBrutoTotal,0,",",".")+'</td>'+
                                  '<td>'+number_format(potonganPPH21,0,",",".")+'</td>'+
                                  '<td>'+number_format(yangDibayarTotal,0,",",".")+'</td>'+
                                  '<td>-</td>'+
                                  '</tr>';
                          $('tbody').append(html);
                        }
                        html = '<tr><td colspan="9" style="text-align:left;text-transform: uppercase;"><b>Satker : '+v.kd_satker_saat_amprah+' - '+v.nm_satker+'</b></td><td></td></tr>';
                        html+='<tr><th>1</th><th>2</th><th>3</th><th>4</th><th>5</th><th>6</th><th>7</th><th>8</th><th>9</th><th>10</th></tr>';
                        $('tbody').append(html);

                        kodeAnakSatker = 0;
                      }

                      // Anak Satker
                      if(kodeAnakSatker !== v.kd_anak_satker_saat_amprah)
                      {
                        if(awal2 == true)
                        {
                          awal2 = false;
                        }
                        
                        html = '<tr><td colspan="9" style="text-align:left;text-transform: uppercase;"><b>Anak Satker : '+v.kd_anak_satker_saat_amprah+' - '+v.nm_anak_satker+'</b></td><td></td></tr>';
                        
                        $('tbody').append(html);
                      }

                      if(v.status_dapat == "1")
                        statusDapat = "Dapat Tunkin";
                      else
                        statusDapat = "Tidak Dapat Tunkin";

                      bruto = parseInt(v.pajak)+parseInt(v.tunjangan);
                      html = '<tr>'+
                               '<td>'+(i++)+'</td>'+
                               '<td class="leftAlign">'+v.nama+'</td>'+
                               '<td class="leftAlign">'+v.nm_pangkat1+'</td>'+
                               '<td>'+v.nip+'</td>'+
                               '<td class="leftAlign">'+v.nm_jabatan+'</td>'+
                               '<td>'+v.kelas_jab_saat_amprah+'</td>'+
                               '<td>'+number_format(v.tunjangan,0,",",".")+'</td>'+
                               '<td>'+number_format(v.pajak,0,",",".")+'</td>'+
                               '<td>'+number_format(bruto,0,",",".")+'</td>'+
                               '<td>'+statusDapat+'</td>'+                               
                              
                             '</tr>';
                      $('tbody').append(html);
                      //tambah or sum pajak
                      
                      
                      if(v.status_dapat == "1")
                      {
                        jumlahPajak+=v.pajak;
                        tunjanganKinerjaTotal+= parseInt(v.tunjangan);
                      }
                      else
                      {
                        tunjanganKinerjaTotal+= 0;
                      }
                      
                      kodeSatker = v.kd_satker_saat_amprah;
                      kodeAnakSatker = v.kd_anak_satker_saat_amprah;                      
                      absensi1total += parseInt(v.absensi1);
                      absensi2total += parseInt(v.absensi2);
                      absensi3total += parseInt(v.absensi3);
                      absensi4total += parseInt(v.absensi4);
                      uang1total+=parseInt(absensVal[1]);
                      uang2total+=parseInt(absensVal[2]);
                      uang3total+=parseInt(absensVal[3]);
                      uang4total+=parseInt(absensVal[4]);
                      jumlahPenguranganTotal +=parseInt(jumlahPengurangan);
                      tunjanganYangDiterimaTotal += parseInt(yangDiterima);
                      tPPH21Total += parseInt(tPPH21);
                      terimaBrutoTotal += parseInt(terimaBruto);
                      potonganPPH21 += parseInt(tPPH21);
                      yangDibayarTotal += parseInt(yangDiterima);

                    });

                    //insert jumlah
                     html = '<tr><td colspan="6">Jumlah</td>'+
                                  '<td>'+number_format(tunjanganKinerjaTotal,0,",",".")+'</td>'+                                  
                                  '<td>'+number_format(jumlahPajak,0,",",".")+'</td>'+
                                  '<td>'+number_format(tunjanganKinerjaTotal+jumlahPajak,0,",",".")+'</td>'+
                                  '<td>-</td>'+
                                  '</tr>';
                          $('tbody').append(html);
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
   </script>
@endsection
