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
              <h3 class="box-title">Laporan LBR KERJA</h3>                            
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
                    REKAPAN PAJAK DAN KELAS JABATAN <span class="keanggotaan"></span> T.A <span class="tahun"></span>
                    <br>POLDA BALI
                    </h5>
                  <h5>Bulan : <span class="waktu"></span></h5>
                  </div>
                <h5>Polri</h5>
               <table border="1" cellpadding="10" id="tableLaporan" class="tablePolri">
                 <thead>
                   <tr class="row1">
                     <th rowspan="2">Grade</th>                     
                   </tr>
                   <tr class="row2">
                     
                   </tr>
                 </thead>
                 <tbody>
                   
                 </tbody>
               </table> 

               <h5>PNS</h5>
              <table border="1" cellpadding="10" id="tableLaporan" class="tablePns">
                 <thead>
                   <tr class="row1">
                     <th rowspan="2">Grade</th>                     
                   </tr>
                   <tr class="row2">
                     
                   </tr>
                 </thead>
                 <tbody>
                   
                 </tbody>
               </table> 

               <h5>TIPIDKOR</h5>
              <table border="1" cellpadding="10" id="tableLaporan" class="tableTipidkor">
                 <thead>
                   <tr class="row1">
                     <th rowspan="2">Grade</th>                     
                   </tr>
                   <tr class="row2">
                     
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
                  datas = [];
                  totalOrang = [];
                  totalPajak = [];
                  totalTunkin = [];
                  dataRowLast = [];
                  for(i= 1 ; i <= 16; i++)
                    {
                      datas[i] = "<tr> <th>"+i+"</th>";
                      totalOrang[i] = 0;
                      totalPajak[i] = 0;
                      totalTunkin[i] = 0;
                    }
                  console.log(data);
                  $('table.tablePolri tbody,table.tablePolri tr.row1,table.tablePolri tr.row2').empty();

                  //POLRI
                  $('table.tablePolri tr.row1').append('<th rowspan="2">Grade</th>');
                  if(data.status = "adadata")
                  {
                    $('#printArea').fadeIn("slow");
                    $('.tahun').html(data.tahun);
                    $('.waktu').html(data.bulan+" "+data.tahun);
                  }                  
                  $.each(data.data,function(k,v){//loop1
                    row1 = "<th colspan='3'>"+v.nm_satker+"</th>";
                    $('table.tablePolri tr.row1').append(row1);
                    row2 = "<th>KLS JAB</th> <th>Tunkin Rp</th> <th>Pajak</th>";
                    $('table.tablePolri tr.row2').append(row2);
                    //
                    dataRowLast[k] = [];
                    dataRowLast[k][0] = 0;
                    dataRowLast[k][1] = 0;
                    dataRowLast[k][2] = 0;
                    //
                    for(i= 1 ; i <= 16; i++)
                    {
                      jumlahOrang = (typeof v.getDataAmprahanPolriGroup[i] === 'undefined') ? 0 : v.getDataAmprahanPolriGroup[i]['jumlahOrang'];                        
                      jumlahTunjangan = (typeof v.getDataAmprahanPolriGroup[i] === 'undefined') ? 0 : parseInt(v.getDataAmprahanPolriGroup[i]['jumlahTunjangan']); 
                      jumlahPajak = (typeof v.getDataAmprahanPolriGroup[i] === 'undefined') ? 0 : parseInt(v.getDataAmprahanPolriGroup[i]['jumlahPajak']); 
                      //
                      totalOrang[i] +=jumlahOrang;
                      totalPajak[i] += jumlahPajak;
                      totalTunkin[i] +=jumlahTunjangan;
                      //
                      datas[i]+="<td>"+jumlahOrang+"</td><td>Rp. "+number_format(jumlahTunjangan,0,",",".")+"</td><td>Rp. "+number_format(jumlahPajak,0,",",".")+"</td>";
                      dataRowLast[k][0]+= jumlahOrang;
                      dataRowLast[k][1]+= jumlahTunjangan;
                      dataRowLast[k][2]+= jumlahPajak;

                    }
                    // bagian kanan


                  });//end loop1
                  row1 = "<th colspan='3'>Jumlah</th>";
                    $('table.tablePolri tr.row1').append(row1);
                    row2 = "<th>KLS JAB</th> <th>Tunkin Rp</th> <th>Pajak</th>";
                    $('table.tablePolri tr.row2').append(row2);
                   for(i= 16 ; i >= 1; i--)
                    {
                      datas[i]+="<td>"+totalOrang[i]+"</td><td>Rp. "+number_format(totalTunkin[i],0,",",".")+"</td><td>Rp. "+number_format(totalPajak[i],0,",",".")+"</td>";
                      datas[i] += "</tr>";
                      $('table.tablePolri tbody').append(datas[i]);
                    }
                    console.log(datas); 
                    //bagian bawah yaitu total
                    grandTotalKelasJab = 0;
                    grandTotalTunkin = 0;
                    grandTotalPajak = 0;
                    //bagian terbawah
                    rowLast = "<tr>"+
                                "<th rowspan='2'>Jumlah</th>";
                    $.each(dataRowLast, function(k,v){
                      rowLast+="<th>"+v[0]+"</th><th>"+number_format(v[1],0,",",".")+"</th><th>"+number_format(v[2],0,",",".")+"</th>";
                      grandTotalKelasJab+=v[0];
                      grandTotalTunkin+=v[1];
                      grandTotalPajak+=v[2];
                    })
                    rowLast+="<th>"+grandTotalKelasJab+"</th><th>"+number_format(grandTotalTunkin,0,",",".")+"</th><th>"+number_format(grandTotalPajak,0,",",".")+"</th>";
                    rowLast+="</tr>";   
                    $('table.tablePolri tbody').append(rowLast);
                    //bagian terbawah banget
                     grandTotalKelasJab = 0;
                    grandTotalTunkin = 0;
                    grandTotalPajak = 0;
                    rowLast = "<tr>";                                
                    $.each(dataRowLast, function(k,v){
                      rowLast+="<th colspan='3'>"+number_format(v[1]+v[2],0,",",".")+"</th>";
                      grandTotalKelasJab+=v[0];
                      grandTotalTunkin+=v[1];
                      grandTotalPajak+=v[2];
                    })
                    rowLast+="<th colspan='3'>"+number_format(grandTotalTunkin+grandTotalPajak,0,",",".")+"</th>";
                    rowLast+="</tr>";   
                    $('table.tablePolri tbody').append(rowLast);



                    //PNS
                  datas = [];
                  totalOrang = [];
                  totalPajak = [];
                  totalTunkin = [];
                  dataRowLast = [];
                  for(i= 1 ; i <= 16; i++)
                    {
                      datas[i] = "<tr> <th>"+i+"</th>";
                      totalOrang[i] = 0;
                      totalPajak[i] = 0;
                      totalTunkin[i] = 0;
                    }
                  console.log(data);
                  $('table.tablePns tbody,table.tablePns tr.row1,table.tablePns tr.row2').empty();
                    //PNS
                    $('table.tablePns tr.row1').append('<th rowspan="2">Grade</th>');
                  if(data.status = "adadata")
                  {
                    $('#printArea').fadeIn("slow");
                    $('.tahun').html(data.tahun);
                    $('.waktu').html(data.bulan+" "+data.tahun);
                  }                  
                  $.each(data.data,function(k,v){//loop1
                    row1 = "<th colspan='3'>"+v.nm_satker+"</th>";
                    $('table.tablePns tr.row1').append(row1);
                    row2 = "<th>KLS JAB</th> <th>Tunkin Rp</th> <th>Pajak</th>";
                    $('table.tablePns tr.row2').append(row2);
                    //
                    dataRowLast[k] = [];
                    dataRowLast[k][0] = 0;
                    dataRowLast[k][1] = 0;
                    dataRowLast[k][2] = 0;
                    //
                    for(i= 1 ; i <= 16; i++)
                    {
                      jumlahOrang = (typeof v.getDataAmprahanPnsGroup[i] === 'undefined') ? 0 : v.getDataAmprahanPnsGroup[i]['jumlahOrang'];                        
                      jumlahTunjangan = (typeof v.getDataAmprahanPnsGroup[i] === 'undefined') ? 0 : parseInt(v.getDataAmprahanPnsGroup[i]['jumlahTunjangan']); 
                      jumlahPajak = (typeof v.getDataAmprahanPnsGroup[i] === 'undefined') ? 0 : parseInt(v.getDataAmprahanPnsGroup[i]['jumlahPajak']); 
                      //
                      totalOrang[i] +=jumlahOrang;
                      totalPajak[i] += jumlahPajak;
                      totalTunkin[i] +=jumlahTunjangan;
                      //
                      datas[i]+="<td>"+jumlahOrang+"</td><td>Rp. "+number_format(jumlahTunjangan,0,",",".")+"</td><td>Rp. "+number_format(jumlahPajak,0,",",".")+"</td>";
                      dataRowLast[k][0]+= jumlahOrang;
                      dataRowLast[k][1]+= jumlahTunjangan;
                      dataRowLast[k][2]+= jumlahPajak;

                    }
                    // bagian kanan


                  });//end loop1
                  row1 = "<th colspan='3'>Jumlah</th>";
                    $('table.tablePns tr.row1').append(row1);
                    row2 = "<th>KLS JAB</th> <th>Tunkin Rp</th> <th>Pajak</th>";
                    $('table.tablePns tr.row2').append(row2);
                   for(i= 16 ; i >= 1; i--)
                    {
                      datas[i]+="<td>"+totalOrang[i]+"</td><td>Rp. "+number_format(totalTunkin[i],0,",",".")+"</td><td>Rp. "+number_format(totalPajak[i],0,",",".")+"</td>";
                      datas[i] += "</tr>";
                      $('table.tablePns tbody').append(datas[i]);
                    }
                    console.log(datas); 
                    //bagian bawah yaitu total
                    grandTotalKelasJab = 0;
                    grandTotalTunkin = 0;
                    grandTotalPajak = 0;
                    //bagian terbawah
                    rowLast = "<tr>"+
                                "<th rowspan='2'>Jumlah</th>";
                    $.each(dataRowLast, function(k,v){
                      rowLast+="<th>"+v[0]+"</th><th>"+number_format(v[1],0,",",".")+"</th><th>"+number_format(v[2],0,",",".")+"</th>";
                      grandTotalKelasJab+=v[0];
                      grandTotalTunkin+=v[1];
                      grandTotalPajak+=v[2];
                    })
                    rowLast+="<th>"+grandTotalKelasJab+"</th><th>"+number_format(grandTotalTunkin,0,",",".")+"</th><th>"+number_format(grandTotalPajak,0,",",".")+"</th>";
                    rowLast+="</tr>";   
                    $('table.tablePns tbody').append(rowLast);
                    //bagian terbawah banget
                     grandTotalKelasJab = 0;
                    grandTotalTunkin = 0;
                    grandTotalPajak = 0;
                    rowLast = "<tr>";                                
                    $.each(dataRowLast, function(k,v){
                      rowLast+="<th colspan='3'>"+number_format(v[1]+v[2],0,",",".")+"</th>";
                      grandTotalKelasJab+=v[0];
                      grandTotalTunkin+=v[1];
                      grandTotalPajak+=v[2];
                    })
                    rowLast+="<th colspan='3'>"+number_format(grandTotalTunkin+grandTotalPajak,0,",",".")+"</th>";
                    rowLast+="</tr>";   
                    $('table.tablePns tbody').append(rowLast);

                    //Tipidkor
                    datas = [];
                  totalOrang = [];
                  totalPajak = [];
                  totalTunkin = [];
                  dataRowLast = [];
                  for(i= 1 ; i <= 16; i++)
                    {
                      datas[i] = "<tr> <th>"+i+"</th>";
                      totalOrang[i] = 0;
                      totalPajak[i] = 0;
                      totalTunkin[i] = 0;
                    }
                  console.log(data);
                  $('table.tableTipidkor tbody,table.tableTipidkor tr.row1,table.tableTipidkor tr.row2').empty();
                    //Tipidkor
                    $('table.tableTipidkor tr.row1').append('<th rowspan="2">Grade</th>');
                  if(data.status = "adadata")
                  {
                    $('#printArea').fadeIn("slow");
                    $('.tahun').html(data.tahun);
                    $('.waktu').html(data.bulan+" "+data.tahun);
                  }                  
                  $.each(data.data,function(k,v){//loop1
                    row1 = "<th colspan='3'>"+v.nm_satker+"</th>";
                    $('table.tableTipidkor tr.row1').append(row1);
                    row2 = "<th>KLS JAB</th> <th>Tunkin Rp</th> <th>Pajak</th>";
                    $('table.tableTipidkor tr.row2').append(row2);
                    //
                    dataRowLast[k] = [];
                    dataRowLast[k][0] = 0;
                    dataRowLast[k][1] = 0;
                    dataRowLast[k][2] = 0;
                    //
                    for(i= 1 ; i <= 16; i++)
                    {
                      jumlahOrang = (typeof v.getDataAmprahanTipidkorGroup[i] === 'undefined') ? 0 : v.getDataAmprahanTipidkorGroup[i]['jumlahOrang'];                        
                      jumlahTunjangan = (typeof v.getDataAmprahanTipidkorGroup[i] === 'undefined') ? 0 : parseInt(v.getDataAmprahanTipidkorGroup[i]['jumlahTunjangan']); 
                      jumlahPajak = (typeof v.getDataAmprahanTipidkorGroup[i] === 'undefined') ? 0 : parseInt(v.getDataAmprahanTipidkorGroup[i]['jumlahPajak']); 
                      //
                      totalOrang[i] +=jumlahOrang;
                      totalPajak[i] += jumlahPajak;
                      totalTunkin[i] +=jumlahTunjangan;
                      //
                      datas[i]+="<td>"+jumlahOrang+"</td><td>Rp. "+number_format(jumlahTunjangan,0,",",".")+"</td><td>Rp. "+number_format(jumlahPajak,0,",",".")+"</td>";
                      dataRowLast[k][0]+= jumlahOrang;
                      dataRowLast[k][1]+= jumlahTunjangan;
                      dataRowLast[k][2]+= jumlahPajak;

                    }
                    // bagian kanan


                  });//end loop1
                  row1 = "<th colspan='3'>Jumlah</th>";
                    $('table.tableTipidkor tr.row1').append(row1);
                    row2 = "<th>KLS JAB</th> <th>Tunkin Rp</th> <th>Pajak</th>";
                    $('table.tableTipidkor tr.row2').append(row2);
                   for(i= 16 ; i >= 1; i--)
                    {
                      datas[i]+="<td>"+totalOrang[i]+"</td><td>Rp. "+number_format(totalTunkin[i],0,",",".")+"</td><td>Rp. "+number_format(totalPajak[i],0,",",".")+"</td>";
                      datas[i] += "</tr>";
                      $('table.tableTipidkor tbody').append(datas[i]);
                    }
                    console.log(datas); 
                    //bagian bawah yaitu total
                    grandTotalKelasJab = 0;
                    grandTotalTunkin = 0;
                    grandTotalPajak = 0;
                    //bagian terbawah
                    rowLast = "<tr>"+
                                "<th rowspan='2'>Jumlah</th>";
                    $.each(dataRowLast, function(k,v){
                      rowLast+="<th>"+v[0]+"</th><th>"+number_format(v[1],0,",",".")+"</th><th>"+number_format(v[2],0,",",".")+"</th>";
                      grandTotalKelasJab+=v[0];
                      grandTotalTunkin+=v[1];
                      grandTotalPajak+=v[2];
                    })
                    rowLast+="<th>"+grandTotalKelasJab+"</th><th>"+number_format(grandTotalTunkin,0,",",".")+"</th><th>"+number_format(grandTotalPajak,0,",",".")+"</th>";
                    rowLast+="</tr>";   
                    $('table.tableTipidkor tbody').append(rowLast);
                    //bagian terbawah banget
                     grandTotalKelasJab = 0;
                    grandTotalTunkin = 0;
                    grandTotalPajak = 0;
                    rowLast = "<tr>";                                
                    $.each(dataRowLast, function(k,v){
                      rowLast+="<th colspan='3'>"+number_format(v[1]+v[2],0,",",".")+"</th>";
                      grandTotalKelasJab+=v[0];
                      grandTotalTunkin+=v[1];
                      grandTotalPajak+=v[2];
                    })
                    rowLast+="<th colspan='3'>"+number_format(grandTotalTunkin+grandTotalPajak,0,",",".")+"</th>";
                    rowLast+="</tr>";   
                    $('table.tableTipidkor tbody').append(rowLast);

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
   </script>
@endsection
