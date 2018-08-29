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
              <h3 class="box-title">Laporan SPP Polri & PNS</h3>                            
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

               <div class="lembarLaporan">             
                  <div class="headerLembarLaporan">
                    <h5 class="titleLaporan">
                      KEPOLISIAN NEGARA REPUBLIK INDONESIA<br>
                      DAERAH BALI<br>
                      STAF PRIBADI PIMPINAN
                    </h5>
                  </div>
                  <div class="judulLaporan">
                    <h3 class="judul">
                      SURAT PERMINTAAN PEMBAYARAN (SPP)
                    </h3>
                    <h5>Nomor : SPP/09/V/2018/Spripim</h5>
                  </div>
                  <div class="bag1">
                    <table>
                      <tr>
                        <td>Dari</td>
                        <td>:</td>
                        <td>KOORSPRIPIM POLDA BALI</td>
                      </tr>
                      <tr>
                        <td>Kepada</td>
                        <td>:</td>
                        <td>KEPALA BIDANG KEUANGAN POLDA BALI </td>
                      </tr>
                    </table>
                  </div>
                  <div class="bag2">
                    <table>
                      <tr>
                        <td>Sebesar</td>
                        <td>:</td>
                        <td class="senilai bold"></td>
                      </tr>
                      <tr>
                        <td>Terbilang</td>
                        <td>:</td>
                        <td class="bold terbilang">-</td>
                      </tr>
                    </table>
                  </div>
                  <div class="bag3">
                    <table>
                      <tr>
                        <td>Untuk</td>
                        <td>:</td>
                        <td class="mengenai"></td>
                      </tr>
                      <tr>
                        <td>Kepada</td>
                        <td>:</td>
                        <td>PAUR KEU SPRIPIM POLDA BALI</td>
                        <td>SKEP PENGUKUHAN PKP</td>
                      </tr>
                      <tr>
                        <td>Alamat</td>
                        <td>:</td>
                        <td>Jln. W.R. Supratman No. 7 Denpasar</td>
                        <td>NPWP : 00.307.356.6-901.000</td>
                      </tr>
                    </table>
                  </div>
                  <div class="bag4">
                    <table>
                      <tr>
                        <td colspan="4">Sprin Kapolda Bali</td>
                      </tr>
                      <tr>
                        <td class="abjad">a.</td>
                        <td class="keterangan">No.Pol</td>
                        <td class="separator">:</td>
                        <td class="isiAngka"></td>
                        <td></td>
                        <td class="senilai">-</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td colspan="3">Tanggal</td>
                      </tr>
                      <tr>
                        <td class="abjad">b.</td>
                        <td class="keterangan">No.Pol</td>
                        <td class="separator">:</td>
                        <td class="isiAngka"></td>
                        <td></td>
                        <td class="senilai2 underscore">-</td>
                      </tr>
                      <tr>
                        <td></td>
                        <td colspan="3">Tanggal</td>
                        <td class="jumlahLabel">Jumlah</td>
                        <td class="senilaiJumlah"></td>
                      </tr>
                       <tr>                        
                        <td colspan="4">SURAT PERJANJIAN / S.P K / SPRIN</td>
                      </tr>
                       <tr>
                        <td>a.</td>
                        <td>Nomor</td>
                        <td>:</td>
                        <td>-</td>
                      </tr>
                       <tr>
                        <td>b.</td>
                        <td>Mengenai</td>
                        <td>:</td>
                        <td class="mengenai"></td>
                      </tr>
                    </table>
                  </div>
                  <div class="bag5">
                    <table>
                      <tr>
                        <td>Pengawasan Sprin Kapolda Bali</td>
                      </tr>
                      <tr>
                        <td>Jumlah Sprin Tersebut Diatas</td>
                        <td></td>
                        <td class="senilai"></td>
                      </tr>
                      <tr>
                        <td>Jumlah Sprin s/d yang lalu</td>
                        <td class="sprinLalu"></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td>Jumlah Sprin ini</td>
                        <td class="senilai underscore"></td>
                        <td></td>
                        
                      </tr>
                      <tr>
                        <td>Jumlah Sprin s/d ini</td>
                        <td></td>
                        <td class="underscore sprinJumlah"></td>
                      </tr>
                      <tr>
                        <td>Sisa Sprin tersebut diatas</td>
                        <td></td>
                        <td class="underscoreDouble sisaSprint"></td>
                      </tr>
                    </table>
                  </div>
                  <div class="bag6">
                    <div class="ttdform">
                        <p>Denpasar, 25 Mei 2018</p>
                        <p>KOORDINATOR STAF PRIBADI PIMPINAN POLDA BALI</p>
                        <img class="ttd">
                        <p>RICKO A.A. TARUNA, S.H.,S.I.K.,M.H.,M.M.</p>
                        <p>KOMPOL NRP 81051412</p>
                    </div>
                    <div class="clearfix"></div>
                  </div>
               </div>
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
                url: "{{route('pilihBulanTahunLaporanSPP')}}",
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
                    $('.lembarLaporan').fadeOut('slow');
                    $('#message').fadeIn("slow").html('Belum Ada Data Absensi');
                    setTimeout(function(){
                      $('#message').fadeOut('slow');
                    },3000)
                  }
                  if(data.dataAbsensi.length == 0)
                  { 
                    $('.lembarLaporan').fadeOut('slow');
                    $('#message').fadeIn("slow").html('Belum Ada Data Absensi');
                    setTimeout(function(){
                      $('#message').fadeOut('slow');
                    },3000)
                  }
                  else if(data.status == "success")
                  {
                    $('.lembarLaporan').fadeIn("slow");
                    i = 1;
                    
                    //mengenai
                    mengenaiWord = data.words;
                    $('.mengenai').html(mengenaiWord);

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
                    jml10 = 0;      
                    jml11 = 0;      
                    jml12 = 0;      

                    senilai2 = 0;
                    sprinLalu = 0;
                    sprinJumlah = 0;
                    sisaSprint = 0;
                    $.each(data.dataAbsensi,function(k,v){     

                      col5 = (v.tunjangan*v.countKelasJab);
                      col6 = 100000*v.countKelasJab;
                      col7 = col5+col6;                      
                      col8 = 0;
                      col9 = 0;
                      col10 = col5-col8;
                      col11 = col6-col9;
                      col12 = col10+col11;
                      
                      jml3+=v.countKelasJab;      
                      jml5+=col5;      
                      jml6+=col6;      
                      jml7+=col7;      
                      jml10+=col10;      
                      jml11+=col11;      
                      jml12+=col12;
                    });
                    $('.senilai').html("Rp.   "+number_format(jml12,0,",","."));
                    $('.terbilang').html('('+terbilang(jml12)+')');
                    senilaiJumlah = jml12+senilai2;
                    $('.senilaiJumlah').html("Rp.   "+number_format(senilaiJumlah,0,",","."));
                    $('.sprinLalu').html("Rp.   "+number_format(sprinLalu,0,",","."));
                    sprinJumlah = sprinLalu+jml12;
                    $('.sprinJumlah').html("Rp.   "+number_format(sprinJumlah,0,",","."));
                    $('.sisaSprint').html("Rp.   "+number_format(sisaSprint,0,",","."));
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



        function terbilang(bilangan) {

           bilangan    = String(bilangan);
           var angka   = new Array('0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0');
           var kata    = new Array('','Satu','Dua','Tiga','Empat','Lima','Enam','Tujuh','Delapan','Sembilan');
           var tingkat = new Array('','Ribu','Juta','Milyar','Triliun');

           var panjang_bilangan = bilangan.length;

           /* pengujian panjang bilangan */
           if (panjang_bilangan > 15) {
             kaLimat = "Diluar Batas";
             return kaLimat;
           }

           /* mengambil angka-angka yang ada dalam bilangan, dimasukkan ke dalam array */
           for (i = 1; i <= panjang_bilangan; i++) {
             angka[i] = bilangan.substr(-(i),1);
           }

           i = 1;
           j = 0;
           kaLimat = "";


           /* mulai proses iterasi terhadap array angka */
           while (i <= panjang_bilangan) {

             subkaLimat = "";
             kata1 = "";
             kata2 = "";
             kata3 = "";

             /* untuk Ratusan */
             if (angka[i+2] != "0") {
               if (angka[i+2] == "1") {
                 kata1 = "Seratus";
               } else {
                 kata1 = kata[angka[i+2]] + " Ratus";
               }
             }

             /* untuk Puluhan atau Belasan */
             if (angka[i+1] != "0") {
               if (angka[i+1] == "1") {
                 if (angka[i] == "0") {
                   kata2 = "Sepuluh";
                 } else if (angka[i] == "1") {
                   kata2 = "Sebelas";
                 } else {
                   kata2 = kata[angka[i]] + " Belas";
                 }
               } else {
                 kata2 = kata[angka[i+1]] + " Puluh";
               }
             }

             /* untuk Satuan */
             if (angka[i] != "0") {
               if (angka[i+1] != "1") {
                 kata3 = kata[angka[i]];
               }
             }

             /* pengujian angka apakah tidak nol semua, lalu ditambahkan tingkat */
             if ((angka[i] != "0") || (angka[i+1] != "0") || (angka[i+2] != "0")) {
               subkaLimat = kata1+" "+kata2+" "+kata3+" "+tingkat[j]+" ";
             }

             /* gabungkan variabe sub kaLimat (untuk Satu blok 3 angka) ke variabel kaLimat */
             kaLimat = subkaLimat + kaLimat;
             i = i + 3;
             j = j + 1;

           }

           /* mengganti Satu Ribu jadi Seribu jika diperlukan */
           if ((angka[5] == "0") && (angka[6] == "0")) {
             kaLimat = kaLimat.replace("Satu Ribu","Seribu");
           }

           return kaLimat + "Rupiah";
          }
   </script>
@endsection
