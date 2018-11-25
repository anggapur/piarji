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
              <!-- <h3 class="box-title">Laporan Rekap Absensi Tunkin Kekurangan</h3>                             -->
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
                <div class="form-group ">
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
                REKAPITULASI PENERIMAAN KEKURANGAN TUNJANGAN KINERJA <span class="keanggotaan"> </span> <br>POLDA BALI<br>T.A <span class="tahun"></span>
                </h5>
              <h5>Bulan : <span class="waktu"></span></h5>
              </div>
              <table class="table table-bordered" id="tableLaporanPerSatker">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Kode Satker</th>
                    <th>Nama Satker</th>
                    <th>Penerimaan</th>
                    <th>Realisasi</th>
                    <th>PPH 21 Disetor Ke Kas Negara</th>
                    <th>Pengembalian PPH21</th>
                    <th>Pengembalian Tunkin</th>
                    
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
                url: "{{route('pilihBulanTahunLaporanKekurangan')}}",
                data: 
                { 
                  "_token": "{{ csrf_token() }}",
                  "bulan" : bulan,
                  "tahun" : tahun,
                  "satker" : satker,
                  "anakSatker" : "all",
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
                    awal = true;
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

                    //console.log('KKK:'+kodeSatker);
                    dataPerSatker = [];
                    iteration = -1;
                    $.each(data.dataAbsensi,function(k,v){                      
                      absensVal[1] = parseInt(absensiFormulaMath(formula1,parseInt(v.tunjangan),v.absensi1));
                      absensVal[2] = parseInt(absensiFormulaMath(formula2,parseInt(v.tunjangan),v.absensi2));
                      absensVal[3] = parseInt(absensiFormulaMath(formula3,parseInt(v.tunjangan),v.absensi3));
                      absensVal[4] = parseInt(absensiFormulaMath(formula4,parseInt(v.tunjangan),v.absensi4));
                      jumlahPengurangan = parseInt(absensVal.reduce(getSum));
                      // yangDiterima = parseInt(parseInt(v.tunjangan)-parseInt(jumlahPengurangan));
                      yangDiterima = parseInt(parseInt(v.tunjangan));
                      tPPH21 = parseInt(v.pajak);
                      terimaBruto = parseInt(parseInt(yangDiterima)+parseInt(tPPH21));                      

                      if(kodeSatker !== v.kd_satker)
                      {
                        iteration++;
                        dataPerSatker[iteration] = [];
                        dataPerSatker[iteration]['id_iteration'] = iteration;
                        dataPerSatker[iteration]['kd_satker'] = v.kd_satker;
                        dataPerSatker[iteration]['nm_satker'] = v.nm_satker;
                        dataPerSatker[iteration]['jumlahBruto'] = 0;
                        dataPerSatker[iteration]['pph21'] = 0;
                        dataPerSatker[iteration]['jumlahPenguranganTotal'] = 0;
                        dataPerSatker[iteration]['pengembalianTunkin'] = 0;
                        dataPerSatker[iteration]['pajakAwal'] = 0;
                      }

                      
                      
                      dataPerSatker[iteration]['jumlahBruto'] += terimaBruto;
                      dataPerSatker[iteration]['pph21'] += tPPH21;
                      dataPerSatker[iteration]['jumlahPenguranganTotal'] +=parseInt(jumlahPengurangan);
                      dataPerSatker[iteration]['pengembalianTunkin'] +=parseInt(v.jumlahPengurangan);
                      dataPerSatker[iteration]['pajakAwal'] += v.pajakAwal;

                      kodeSatker = v.kd_satker;
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

                      

                    });                                        
                  // console.log(dataPerSatker);
                  // console.log(data.satker);
                  totalMoneyPPH = 0;
                  totalMoneyBruto = 0;
                  totalPengembalianPPH21 = 0;
                  totalPengembalianTunkin = 0;
                  totalRealisasi = 0;
                  listSatker = dataPerSatker;
                  pengembalianPPH21 = 0;
                  pengembalianTunkin =0;
                  iteration = 1;
                   $.each(data.satker,function(k,v){ 
                    dataMoney = listSatker.filter(function (person) { return person.kd_satker == v.kd_satker })[0];
                    console.log(dataMoney);
                    if(dataMoney == undefined)
                    {
                      moneyPPH = 0;
                      moneyBruto = 0;
                      jumlahPengurangan = 0 ;    
                      pengembalianTunkin = 0;    
                      pengembalianPPH21 = 0; 
                    }
                    else
                    {
                      moneyPPH = dataMoney['pph21'];
                      moneyBruto = dataMoney['jumlahBruto'];
                      jumlahPengurangan = dataMoney['jumlahPenguranganTotal'];
                      pengembalianTunkin = dataMoney['pengembalianTunkin'];
                      pengembalianPPH21 = dataMoney['pajakAwal'];
                    }
                    realisasi = moneyBruto-moneyPPH;
                    pengembalianTot = 0; //data.amprahan[v.kd_satker] - (realisasi-jumlahPengurangan) - moneyPPH;
                    totalRealisasi+=realisasi;
                    html = '<tr>'+
                            '<td>'+(iteration++)+'</td>'+
                            '<td>'+v.kd_satker+'</td>'+
                            '<td>'+v.nm_satker+'</td>'+
                            // '<td>Rp. '+number_format(data.amprahan[v.kd_satker],0,",",".")+'</td>'+                            
                            '<td>Rp. '+number_format(0,0,",",".")+'</td>'+                            
                            '<td>Rp. '+number_format(realisasi-jumlahPengurangan,0,",",".")+'</td>'+ 
                            '<td>Rp. '+number_format(moneyPPH,0,",",".")+'</td>'+                           
                            '<td>Rp. '+number_format((pengembalianPPH21-moneyPPH),0,",",".")+'</td>'+                             
                            '<td>Rp. '+number_format(pengembalianTunkin,0,",",".")+'</td>'+                                                        
                            
                            '</tr>';
                    $('#tableLaporanPerSatker').append(html);
                    totalMoneyPPH +=moneyPPH;
                    totalMoneyBruto += moneyBruto;
                    totalPengembalianPPH21 += (pengembalianPPH21-moneyPPH);
                    totalPengembalianTunkin += pengembalianTunkin;
                   });
                   html = '<tr>'+                            
                            '<th colspan="3">Total</th>'+
                            '<th>Rp. '+number_format(totalMoneyBruto,0,",",".")+'</th>'+
                            '<th>Rp. '+number_format(totalRealisasi,0,",",".")+'</th>'+
                            '<th>Rp. '+number_format(totalMoneyPPH,0,",",".")+'</th>'+
                            '<th>Rp. '+number_format(totalPengembalianPPH21,0,",",".")+'</th>'+
                            '<th>Rp. '+number_format(totalPengembalianTunkin,0,",",".")+'</th>'+
                            
                            '</tr>';
                    $('#tableLaporanPerSatker').append(html);

                  }//else success
                  
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
