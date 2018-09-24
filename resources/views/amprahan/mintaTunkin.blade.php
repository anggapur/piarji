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
              <h3 class="box-title">Laporan Minta Tunkin</h3>                            
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
              <div id="printArea" class="printArea" style="display: none;">
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
                    REKAPITULASI PERMINTAAN TUNJANGAN KINERJA PEGAWAI <span class="keanggotaan"></span> T.A <span class="tahun"></span>
                    <br>POLDA BALI
                    </h5>
                  <h5>Bulan : <span class="waktu"></span></h5>
                  </div>
               <table border="1" cellpadding="10" id="tableLaporan">
                 <thead>
                   <tr>
                     <th rowspan="2">No</th>
                     <th rowspan="2">Satker</th>
                     <th colspan="4">Polri</th>
                     <th colspan="4">PNS</th>
                     <th rowspan="2">Bruto</th>
                     <th rowspan="2">Ket</th>
                   </tr>
                   <tr>
                     <th>Kuat Pers</th>
                     <th>Jml Bruto</th>
                     <th>PPH21</th>
                     <th>Jumlah Dibayarkan</th>
                     <th>Kuat Pers</th>
                     <th>Jml Bruto</th>
                     <th>PPH21</th>
                     <th>Jumlah Dibayarkan</th>                     
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
                url: "{{route('apiMintaTunkin')}}",
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
                  $('tbody').empty();
                  if(data.status = "adadata")
                  {
                    $('#printArea').fadeIn("slow");
                    $('.tahun').html(data.tahun);
                    $('.waktu').html(data.bulan+" "+data.tahun);
                  }
                  i = 1;

                  totalGet_data_amprahan_polri_count = 0; 
                  totalBrutoPolri = 0; 
                  totalSumPajakPolri = 0; 
                  totalSumDibayarkanPolri = 0; 
                  totalGet_data_amprahan_pns_count = 0; 
                  totalBrutoPns = 0; 
                  totalSumPajakPns = 0; 
                  totalSumDibayarkanPns = 0; 

                  $.each(data.data,function(k,v){
                    
                    get_data_amprahan_polri_count = parseInt(v.get_data_amprahan_polri_count);
                    brutoPolri = parseInt(v.brutoPolri);
                    sumPajakPolri = parseInt(v.sumPajakPolri);
                    sumDibayarkanPolri = parseInt(v.sumDibayarkanPolri);
                    get_data_amprahan_pns_count = parseInt(v.get_data_amprahan_pns_count);
                    brutoPns = parseInt(v.brutoPns);
                    sumPajakPns = parseInt(v.sumPajakPns);
                    sumDibayarkanPns = parseInt(v.sumDibayarkanPns);

                    //total
                    totalGet_data_amprahan_polri_count += parseInt(v.get_data_amprahan_polri_count);
                    totalBrutoPolri += parseInt(v.brutoPolri);
                    totalSumPajakPolri += parseInt(v.sumPajakPolri);
                    totalSumDibayarkanPolri += parseInt(v.sumDibayarkanPolri);
                    totalGet_data_amprahan_pns_count += parseInt(v.get_data_amprahan_pns_count);
                    totalBrutoPns += parseInt(v.brutoPns);
                    totalSumPajakPns += parseInt(v.sumPajakPns);
                    totalSumDibayarkanPns += parseInt(v.sumDibayarkanPns);

                    html = "<tr>"+
                            "<td>"+(i++)+"</td>"+
                            "<td>"+v.nm_satker+"</td>"+
                            "<td>"+get_data_amprahan_polri_count+"</td>"+
                            "<td>Rp. "+number_format(brutoPolri,0,",",".")+"</td>"+
                            "<td>Rp. "+number_format(sumPajakPolri,0,",",".")+"</td>"+
                            "<td>Rp. "+number_format(sumDibayarkanPolri,0,",",".")+"</td>"+
                            "<td>"+get_data_amprahan_pns_count+"</td>"+
                            "<td>Rp. "+number_format(brutoPns,0,",",".")+"</td>"+
                            "<td>Rp. "+number_format(sumPajakPns,0,",",".")+"</td>"+
                            "<td>Rp. "+number_format(sumDibayarkanPns,0,",",".")+"</td>"+
                            "<td>Rp. "+number_format(brutoPolri+brutoPns,0,",",".")+"</td>"+
                            "<td></td>"+
                            "</tr>";
                    $('tbody').append(html);
                  }); // end loop
                  html = "<tr>"+
                            "<td colspan='2'>JML SELURUHNYA</td>"+                            
                            "<td>"+totalGet_data_amprahan_polri_count+"</td>"+
                            "<td>Rp. "+number_format(totalBrutoPolri,0,",",".")+"</td>"+
                            "<td>Rp. "+number_format(totalSumPajakPolri,0,",",".")+"</td>"+
                            "<td>Rp. "+number_format(totalSumDibayarkanPolri,0,",",".")+"</td>"+
                            "<td>"+totalGet_data_amprahan_pns_count+"</td>"+
                            "<td>Rp. "+number_format(totalBrutoPns,0,",",".")+"</td>"+
                            "<td>Rp. "+number_format(totalSumPajakPns,0,",",".")+"</td>"+
                            "<td>Rp. "+number_format(totalSumDibayarkanPns,0,",",".")+"</td>"+
                            "<td>Rp. "+number_format(totalBrutoPolri+totalBrutoPns,0,",",".")+"</td>"+
                            "<td></td>"+
                            "</tr>";
                    $('tbody').append(html);
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
