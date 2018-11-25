@extends('layouts.template')

@section('content')
<div id="dvjson"></div>
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
              <h3 class="box-title">Laporan C1 Polri & C2 PNS</h3>                            
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
                    <option value="">Pilih Satker</option>                  
                    @foreach($dataSatker as $val)
                      <option value="{{$val->kd_satker}}">{{$val->kd_satker." - ".$val->nm_satker}}</option>                  
                    @endforeach
                  </select>                 
                </div>  
                @if(Auth::user()->level == "operator")  
                <div class="form-group">
                  <label>Kode Anak Satker</label>
                  <select class="js-example-basic-single form-control" name="kd_anak_satker">    
                    <option value="all">Semua</option>                
                    @foreach($dataAnakSatker as $val)
                      <option value="{{$val->kd_anak_satker}}" data-satker="{{$val->kd_satker}}">{{$val->kd_anak_satker." - ".$val->nm_anak_satker}}</option>                  
                    @endforeach
                  </select>                 
                </div> 
                @else
                <div class="form-group" id="anakSatkerAdmin">
                  <label>Kode Anak Satker</label>
                  <select class=" form-control" name="kd_anak_satker">    
                    <option value="all">Semua</option>                
                    @foreach($dataAnakSatker as $val)
                      <option value="{{$val->kd_anak_satker}}" data-satker="{{$val->kd_satker}}">{{$val->kd_anak_satker." - ".$val->nm_anak_satker}}</option>                  
                    @endforeach
                  </select>                 
                </div> 
                @endif                 
                <div class="form-group ">
                  <label>Kategori</label>
                  <select class="js-example-basic-single form-control" name="jenis_pegawai">    
                    {!!CH::printOptionJenisPegawai()!!}              
                  </select>                 
                </div>  
                <div class="form-group">
                  <input type="submit" name="submitBulanTahun" value="Pilih" class="btn btn-success" id="btnPilih">
                  <button type="button" class="btn btn-default" onClick="printReport()">Print</button>
                  <button type="button" class="btn btn-primary" onClick="exportDataBank()">Export Data Untuk Bank</button>
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
                    DAFTAR PEMBAYARAN TUNJANGAN KINERJA <span class="keanggotaan"></span> T.A <span class="tahun"></span>
                    </h5>
                  <h5>Bulan : <span class="waktu"></span></h5>
                  <h5 class="satkerName"></h5>
                  </div>
               <div class="tablePlace"></div> 
               @if(Auth::user()->level == "operator") 
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
          //$('#btnPilih').click();
          setTimeout(function(){
            window.print();
          },1000);
        
          var prtContent = document.getElementById("printArea");      
      }
  </script>

   <script type="text/javascript">
    $(document).ready(function(){
      $('#anakSatkerAdmin select[name="kd_anak_satker"]').find('option').not('[value="all"]').hide();
      $('select[name="kd_satker"]').change(function(){
        $('#anakSatkerAdmin select[name="kd_anak_satker"]').find('option').not('[value="all"]').hide();
        kd_satker = $(this).val();
        $('#anakSatkerAdmin select[name="kd_anak_satker"]').val("all");
        $('#anakSatkerAdmin select[name="kd_anak_satker"]').find('option[data-satker="'+kd_satker+'"]').show();
      });
    });
    titleExcel = "";
     dataExport = [];
      singleDataExport = [];
    var templateAtas = '<table border="1" cellpadding="10" id="tableLaporan">'+
                 '<thead>'+
                  '<tr>'+
                     '<th rowspan="2">No</th>'+
                     '<th rowspan="2">Nama</th>'+
                     '<th rowspan="2" id="thPangkatGologan">Pangkat / Golongan</th>'+
                     '<th rowspan="2">NRP</th>'+
                     '<th rowspan="2">Jabatan</th>'+
                     '<th rowspan="2">Kelas Jabatan</th>'+
                     '<th rowspan="2">T. Kinerja</th>'+
                     '<th colspan="2" class="w100">{{collect($aturan_absensi)->firstWhere('id','1')->nama}}</th> '+                                         
                     '<th colspan="2" class="w100">{{collect($aturan_absensi)->firstWhere('id','2')->nama}}</th> '+                    
                     '<th colspan="2" class="w100">{{collect($aturan_absensi)->firstWhere('id','3')->nama}}</th> '+                    
                     '<th colspan="2" class="w100">{{collect($aturan_absensi)->firstWhere('id','4')->nama}}</th>'+
                     '<th rowspan="2" class="w50">Jumlah Pengurangan</th>  '+                   
                     '<th rowspan="2" class="w50">Tunjangan Yang Diterima</th>'+
                     '<th rowspan="2" class="w50">T.PPH21</th>'+
                     '<th rowspan="2" class="w50">Terima Bruto</th>'+
                     '<th rowspan="2" class="w50">Potongan<br>PPH-21</th>'+
                     '<th rowspan="2" class="w50">T.Yang Dibayar</th>'+
                     '<th rowspan="2" class="w50">Rekening</th>'+
                   '</tr>  '+                
                   '<tr>'+                   
                     '<th>Hari</th>'+
                     '<th>Rp</th>'+
                     '<th>Hari</th>'+
                     '<th>Rp</th>'+
                     '<th>Hari</th>'+
                     '<th>Rp</th>'+
                     '<th>Hari</th>'+
                     '<th>Rp</th>'+
                   '</tr>'+
                    '<tr>'+
                     '<th>1</th>'+
                     '<th>2</th>'+
                     '<th>3</th>'+
                     '<th>4</th>'+
                     '<th>5</th>'+
                     '<th>6</th>'+
                     '<th>7</th>'+
                     '<th>8</th>'+
                     '<th>9</th>'+
                     '<th>10</th>'+
                     '<th>11</th>'+
                     '<th>12</th>'+
                     '<th>13</th>'+
                     '<th>14</th>'+
                     '<th>15</th>'+
                     '<th>16</th>'+
                     '<th>17</th>'+
                     '<th>18</th>'+
                     '<th>19</th>'+
                     '<th>20</th>'+
                     '<th>21</th>'+
                     '<th>22</th>'+
                   '</tr>'+
                 '</thead>'+
                 '<tbody>';
        var templateBawah = '</tbody>'+
               '</table>';
      //alert(parseInt(1000.4));
      //form bulan tahun
        $('#formBulanTahun').submit(function(e){     
        $('.showWhenLoading').fadeIn("slow");     
          bulan = $(this).find("select[name='bulan']").val();
          tahun = $(this).find("select[name='tahun']").val();
          satker = $(this).find("select[name='kd_satker']").val();
          anakSatker = $(this).find("select[name='kd_anak_satker']").val();
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
                url: "{{route('pilihBulanTahunLaporanSusulan')}}",
                data: 
                { 
                  "_token": "{{ csrf_token() }}",
                  "bulan" : bulan,
                  "tahun" : tahun,
                  "satker" : satker,
                  "anakSatker" : anakSatker,
                  "jenis_pegawai" : jenis_pegawai,
                },
                success: function(data) {
                  //print satker
                  
                  console.log(data);
                  if(data.status == "nodata")
                  { 
                    $('.showWhenLoading').fadeOut("slow");
                    $('#printArea').fadeOut('slow');
                    $('#message').fadeIn("slow").html('Belum Ada Data Absensi');
                    setTimeout(function(){
                      $('#message').fadeOut('slow');
                    },3000)
                  }
                  if(data.dataAbsensi.length == 0)
                  { 
                    $('.showWhenLoading').fadeOut("slow");
                    $('#printArea').fadeOut('slow');
                    $('#message').fadeIn("slow").html('Belum Ada Data Absensi');
                    setTimeout(function(){
                      $('#message').fadeOut('slow');
                    },3000)
                  }
                  else if(data.status == "success")
                  {
                    noUrut = 1;
                    $('.satkerName').html(data.selectedSatker.nm_satker);
                    $('.tablePlace').empty();
                    $('.keanggotaan').html(data.keanggotaan);
                    i = 1;
                    $('#printArea').fadeIn('slow');
                    $('tbody').empty();

                    $('.waktu').html(data.bulan+" "+data.tahun);
                    $('.tahun').html(data.tahun);
                    titleExcel="";
                    titleExcel+="DAFTAR PEMBAYARAN TUNJANGAN KINERJA POLRI & PNS T.A 2018 \nBULAN "+data.bulan+" TAHUN "+data.tahun+" \nSATKER "+data.selectedSatker.nm_satker;

                    dataExport = [];

                    dataExport.push([{"text":titleExcel}]);
                    dataExport.push([{"text":""}]);
                    dataExport.push([{"text":""}]);

                    singleDataExport.push({"text":"No Urut"});
                    singleDataExport.push({"text":"NRP"});
                    singleDataExport.push({"text":"Nama"});
                    singleDataExport.push({"text":"Yang DIterima "});
                    singleDataExport.push({"text":"No Rekening"});
                    dataExport.push(singleDataExport);
                    singleDataExport = [];

                    console.log(data.formula);
                    // formula1 = data.formula[0]['rumus'];
                    // formula2 = data.formula[1]['rumus'];
                    // formula3 = data.formula[2]['rumus'];
                    // formula4 = data.formula[3]['rumus'];
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
                    templateAppend = "";
                     tunjanganKinerjaTotalPerHalaman = 0;
                    absensi1totalPerHalaman = 0;
                    absensi2totalPerHalaman = 0;
                    absensi3totalPerHalaman = 0;
                    absensi4totalPerHalaman = 0;
                    uang1totalPerHalaman = 0;
                    uang2totalPerHalaman = 0;
                    uang3totalPerHalaman = 0;
                    uang4totalPerHalaman = 0;
                    jumlahPenguranganTotalPerHalaman = 0;
                    tunjanganYangDiterimaTotalPerHalaman = 0;
                    tPPH21TotalPerHalaman = 0;
                    terimaBrutoTotalPerHalaman = 0;
                    potonganPPH21PerHalaman = 0;
                    yangDibayarTotalPerHalaman = 0;

                    console.log('KKK:'+kodeSatker);
                    $.each(data.dataAbsensi,function(k,v){        
                       // console.log("koko : "+v.nm_anak_satker);              
                      absensVal[1] = v.absensiValue1;
                      absensVal[2] = v.absensiValue2;
                      absensVal[3] = v.absensiValue3;
                      absensVal[4] = v.absensiValue4;
                      jumlahPengurangan = v.jumlahPengurangan;
                      yangDiterima = parseInt(parseInt(v.tunjangan)-parseInt(jumlahPengurangan));
                      tPPH21 = parseInt(v.pajak);
                      terimaBruto = parseInt(parseInt(yangDiterima)+parseInt(tPPH21));                      

                      if(kodeAnakSatker !== v.kd_anak_satker_saat_absensi)
                      {
                        if(awal2 == true)
                        {
                          // alert('awal');
                          templateAppend+=("<h5>SUBSATKER : "+v.nm_anak_satker+"</h5>");
                          templateAppend+= templateAtas;
                          awal2 = false;
                        }
                        else
                        {
                           // alert('tengah');
                           templateAppend+= '<tr><td colspan="6">Jumlah Per Halaman</td>'+
                                  '<td>'+number_format(tunjanganKinerjaTotalPerHalaman,0,",",".")+'</td>'+
                                  '<td>'+absensi1total+'</td>'+
                                  '<td>'+number_format(uang1totalPerHalaman,0,",",".")+'</td>'+
                                  '<td>'+absensi2total+'</td>'+
                                  '<td>'+number_format(uang2totalPerHalaman,0,",",".")+'</td>'+
                                  '<td>'+absensi3total+'</td>'+
                                  '<td>'+number_format(uang3totalPerHalaman,0,",",".")+'</td>'+
                                  '<td>'+absensi4total+'</td>'+
                                  '<td>'+number_format(uang4totalPerHalaman,0,",",".")+'</td>'+
                                  '<td>'+number_format(jumlahPenguranganTotalPerHalaman,0,",",".")+'</td>'+
                                  '<td>'+number_format(tunjanganYangDiterimaTotalPerHalaman,0,",",".")+'</td>'+
                                  '<td>'+number_format(tPPH21TotalPerHalaman,0,",",".")+'</td>'+
                                  '<td>'+number_format(terimaBrutoTotalPerHalaman,0,",",".")+'</td>'+
                                  '<td>'+number_format(potonganPPH21PerHalaman,0,",",".")+'</td>'+
                                  '<td>'+number_format(yangDibayarTotalPerHalaman,0,",",".")+'</td>'+
                                  '<td>-</td>'+
                                  '</tr>';
                          templateAppend+=templateBawah;
                          $('.tablePlace').append(templateAppend);
                          templateAppend = "";
                          templateAppend+=("<div class='pagebreak'></div> <h5>SUBSATKER : "+v.nm_anak_satker+"</h5>");
                          templateAppend+=templateAtas;

                          //reset
                          tunjanganKinerjaTotalPerHalaman = 0;
                          absensi1totalPerHalaman = 0;
                          absensi2totalPerHalaman = 0;
                          absensi3totalPerHalaman = 0;
                          absensi4totalPerHalaman = 0;
                          uang1totalPerHalaman = 0;
                          uang2totalPerHalaman = 0;
                          uang3totalPerHalaman = 0;
                          uang4totalPerHalaman = 0;
                          jumlahPenguranganTotalPerHalaman = 0;
                          tunjanganYangDiterimaTotalPerHalaman = 0;
                          tPPH21TotalPerHalaman = 0;
                          terimaBrutoTotalPerHalaman = 0;
                          potonganPPH21PerHalaman = 0;
                          yangDibayarTotalPerHalaman = 0;
                        }                         
                      }

                      templateAppend+= '<tr>'+
                               '<td>'+(i)+'</td>'+
                               '<td class="leftAlign">'+v.nama+'</td>'+
                               '<td class="leftAlign">'+v.nm_pangkat1+'</td>'+
                               '<td>'+v.nip+'</td>'+
                               '<td class="leftAlign">'+v.nm_jabatan+'</td>'+
                               '<td>'+v.kelas_jab_saat_absensi+'</td>'+
                               '<td>'+number_format(v.tunjangan,0,",",".")+'</td>'+
                               '<td>'+v.absensi1+'</td>'+
                               '<td>'+number_format(absensVal[1],0,",",".")+'</td>'+
                               '<td>'+v.absensi2+'</td>'+
                               '<td>'+number_format(absensVal[2],0,",",".")+'</td>'+
                               '<td>'+v.absensi3+'</td>'+
                               '<td>'+number_format(absensVal[3],0,",",".")+'</td>'+
                               '<td>'+v.absensi4+'</td>'+
                               '<td>'+number_format(absensVal[4],0,",",".")+'</td>'+
                               '<td>'+number_format(jumlahPengurangan,0,",",".")+'</td>'+
                               '<td>'+number_format(yangDiterima,0,",",".")+'</td>'+
                               '<td>'+number_format(tPPH21,0,",",".")+'</td>'+
                               '<td>'+number_format(terimaBruto,0,",",".")+'</td>'+
                               '<td>'+number_format(tPPH21,0,",",".")+'</td>'+
                               '<td>'+number_format(yangDiterima,0,",",".")+'</td>'+
                               '<td class="wrapper_ttd_field"> <div class="ttd_field">'+(i++)+'</div><span class="no_rekening_field">'+v.no_rekening+'</span></td>'+
                             '</tr>';
                      //insert dataExport
                      singleDataExport.push({"text":noUrut++});
                      singleDataExport.push({"text":"\t"+v.nip.toString()});
                      singleDataExport.push({"text":v.nama});
                      singleDataExport.push({"text":yangDiterima});
                      singleDataExport.push({"text":"\t"+v.no_rekening.toString()});
                      dataExport.push(singleDataExport);
                      singleDataExport = [];

                      //
                      kodeSatker = v.kd_satker_saat_absensi;
                      kodeAnakSatker = v.kd_anak_satker_saat_absensi;
                      tunjanganKinerjaTotal+= parseInt(v.tunjangan);
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

                      //per halaman
                      tunjanganKinerjaTotalPerHalaman+= parseInt(v.tunjangan);
                      absensi1totalPerHalaman += parseInt(v.absensi1);
                      absensi2totalPerHalaman += parseInt(v.absensi2);
                      absensi3totalPerHalaman += parseInt(v.absensi3);
                      absensi4totalPerHalaman += parseInt(v.absensi4);
                      uang1totalPerHalaman+=parseInt(absensVal[1]);
                      uang2totalPerHalaman+=parseInt(absensVal[2]);
                      uang3totalPerHalaman+=parseInt(absensVal[3]);
                      uang4totalPerHalaman+=parseInt(absensVal[4]);
                      jumlahPenguranganTotalPerHalaman +=parseInt(jumlahPengurangan);
                      tunjanganYangDiterimaTotalPerHalaman += parseInt(yangDiterima);
                      tPPH21TotalPerHalaman += parseInt(tPPH21);
                      terimaBrutoTotalPerHalaman += parseInt(terimaBruto);
                      potonganPPH21PerHalaman += parseInt(tPPH21);
                      yangDibayarTotalPerHalaman += parseInt(yangDiterima);



                    });//EACH
                    
                    templateAppend+= '<tr><td colspan="6">Jumlah Per Halaman</td>'+
                                  '<td>'+number_format(tunjanganKinerjaTotalPerHalaman,0,",",".")+'</td>'+
                                  '<td>'+absensi1total+'</td>'+
                                  '<td>'+number_format(uang1totalPerHalaman,0,",",".")+'</td>'+
                                  '<td>'+absensi2total+'</td>'+
                                  '<td>'+number_format(uang2totalPerHalaman,0,",",".")+'</td>'+
                                  '<td>'+absensi3total+'</td>'+
                                  '<td>'+number_format(uang3totalPerHalaman,0,",",".")+'</td>'+
                                  '<td>'+absensi4total+'</td>'+
                                  '<td>'+number_format(uang4totalPerHalaman,0,",",".")+'</td>'+
                                  '<td>'+number_format(jumlahPenguranganTotalPerHalaman,0,",",".")+'</td>'+
                                  '<td>'+number_format(tunjanganYangDiterimaTotalPerHalaman,0,",",".")+'</td>'+
                                  '<td>'+number_format(tPPH21TotalPerHalaman,0,",",".")+'</td>'+
                                  '<td>'+number_format(terimaBrutoTotalPerHalaman,0,",",".")+'</td>'+
                                  '<td>'+number_format(potonganPPH21PerHalaman,0,",",".")+'</td>'+
                                  '<td>'+number_format(yangDibayarTotalPerHalaman,0,",",".")+'</td>'+
                                  '<td>-</td>'+
                                  '</tr>';
  
                    //insert jumlah
                     templateAppend+= '<tr><th colspan="6">Jumlah Total</th>'+
                                  '<th>'+number_format(tunjanganKinerjaTotal,0,",",".")+'</th>'+
                                  '<th>'+absensi1total+'</th>'+
                                  '<th>'+number_format(uang1total,0,",",".")+'</th>'+
                                  '<th>'+absensi2total+'</th>'+
                                  '<th>'+number_format(uang2total,0,",",".")+'</th>'+
                                  '<th>'+absensi3total+'</th>'+
                                  '<th>'+number_format(uang3total,0,",",".")+'</th>'+
                                  '<th>'+absensi4total+'</th>'+
                                  '<th>'+number_format(uang4total,0,",",".")+'</th>'+
                                  '<th>'+number_format(jumlahPenguranganTotal,0,",",".")+'</th>'+
                                  '<th>'+number_format(tunjanganYangDiterimaTotal,0,",",".")+'</th>'+
                                  '<th>'+number_format(tPPH21Total,0,",",".")+'</th>'+
                                  '<th>'+number_format(terimaBrutoTotal,0,",",".")+'</th>'+
                                  '<th>'+number_format(potonganPPH21,0,",",".")+'</th>'+
                                  '<th>'+number_format(yangDibayarTotal,0,",",".")+'</th>'+
                                  '<th>-</th>'+
                                  '</tr>';
                    templateAppend+=templateBawah;
                    $('.tablePlace').append(templateAppend);
                    templateAppend = "";
                    console.log('end each');
                    $('.showWhenLoading').fadeOut("slow");
                    console.log(dataExport);
                    

                    
                  }
                }
            });
          e.preventDefault();
        });
        function exportDataBank()
        {
          // JSONToCSVConvertor(dataExport, titleExcel, true);
          var tableData = [
            {
                "sheetName": "Sheet1",
                "data": dataExport
            }
          ];
          console.log(tableData[0].data);
          var options = {
              fileName: titleExcel
          };
          Jhxlsx.export(tableData, options);
        }
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
        function JSONToCSVConvertor(JSONData, ReportTitle, ShowLabel) {
          //If JSONData is not an object then JSON.parse will parse the JSON string in an Object
          var arrData = typeof JSONData != 'object' ? JSON.parse(JSONData) : JSONData;

          var CSV = '';
          //Set Report title in first row or line

          CSV += ReportTitle + '\r\n\n';

          //This condition will generate the Label/Header
          if (ShowLabel) {
            var row = "";

            //This loop will extract the label from 1st index of on array
            for (var index in arrData[0]) {

              //Now convert each value to string and comma-seprated
              row += index + ',';
            }

            row = row.slice(0, -1);

            //append Label row with line break
            CSV += row + '\r\n';
          }

          //1st loop is to extract each row
          for (var i = 0; i < arrData.length; i++) {
            var row = "";

            //2nd loop will extract each column and convert it in string comma-seprated
            for (var index in arrData[i]) {
              row += '"' + arrData[i][index] + '",';
            }

            row.slice(0, row.length - 1);

            //add a line break after each row
            CSV += row + '\r\n';
          }

          if (CSV == '') {
            alert("Invalid data");
            return;
          }

          //Generate a file name
          var fileName = "MyReport_";
          //this will remove the blank-spaces from the title and replace it with an underscore
          fileName += ReportTitle.replace(/ /g, "_");

          //Initialize file format you want csv or xls
          var uri = 'data:text/csv;charset=utf-8,' + escape(CSV);

          // Now the little tricky part.
          // you can use either>> window.open(uri);
          // but this will not work in some browsers
          // or you will not get the correct file extension    

          //this trick will generate a temp <a /> tag
          var link = document.createElement("a");
          link.href = uri;

          //set the visibility hidden so it will not effect on your web-layout
          link.style = "visibility:hidden";
          link.download = fileName + ".xlsx";

          //this part will append the anchor tag and remove it after automatic click
          document.body.appendChild(link);
          link.click();
          document.body.removeChild(link);
        }
   </script>
@endsection
