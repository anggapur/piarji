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
              <h3 class="box-title">Form Kwitansi Polri/PNS</h3>                            
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

            <div class="box" style="border-top: 0px">
              <div class="box-body">
              <div class="lembarLaporanKU">
                <div class="headerKU">
                  <div class="leftKU">
                    <div class="logoPolriLaporan"><img src="{{url('public/asset/Logo-POLRI-bw.png')}}"></div>
                    <h5>KEPOLISIAN NEGARA REPUBLIK INDONESIA <br> DAERAH BALI <br> <span class="satkerNama"></span></h5>
                  </div>
                  <div class="rightKU">
                    <h5>Bukti Kas : </h5>
                  </div>
                  <div class="clearfix"></div>
                </div>
                <div class="judulKU">
                  <h3>KWITANSI TUNKIN SUSULAN</h3>
                </div>
                <div class="bodyKU">
                  <div class="bag1KU">
                    <table>
                      <tr>
                        <td>Tahun Anggaran</td>
                        <td>:</td>
                        <td>2018</td>
                      </tr>
                      <tr>
                        <td>Kode Akun</td>
                        <td>:</td>
                        <td>-</td>
                      </tr>
                      <tr>
                        <td>Jenis Pengeluaran</td>
                        <td>:</td>
                        <td>Tunjangan Kinerja</td>
                      </tr>
                    </table>
                  </div>
                  <div class="bag2KU">
                    <table>
                      <tr>
                        <td>Terima Dari </td>
                        <td>:</td>
                        <td colspan="2">KABIDKEU POLDA BALI</td>
                      </tr>
                      <tr>
                        <td>Uang sejumlah Rp.</td>
                        <td>:</td>
                        <td class="senilai"></td>
                        <td class="terbilang"></td>
                      </tr>
                       <tr>
                        <td>Untuk Pembayaran </td>
                        <td>:</td>
                        <td colspan="2" class="mengenai bag31" data-word="3-1"></td>
                      </tr>
                    </table>
                  </div>
                </div>
                <div class="footerKU">
                  <div class="leftKU">
                    <h5 style="margin-bottom:0px; margin-top: 10px;" class="bag14">1-4</h5>
                    <h5 style="margin-top:0px;">Yang membayarkan</h5>
                    <div class="space"></div>
                    <table>
                      <tr>
                        <td>Nama</td>
                        <td>:</td>
                        <td class="bag12">1-2</td>
                      </tr>
                      <tr>
                        <td>Pangkat/NRP</td>
                        <td>:</td>
                        <td class="bag13">1-3</td>
                      </tr>
                      <tr>
                        <td>Jabatan</td>
                        <td>:</td>
                        <td class="bag11">1-1</td>
                      </tr>
                      <tr>
                        <td>Alamat</td>
                        <td>:</td>
                        <td class="bag15">1-5</td>
                      </tr>
                    </table>
                  </div>
                  <div class="rightKU">
                    <h5 style="margin-bottom:0px;" class="bag24">2-4</h5>
                    <h5 style="margin-top:0px;">Yang menerima</h5>
                    <div class="space"></div>
                    <table>
                      <tr>
                        <td>Nama</td>
                        <td>:</td>
                        <td class="bag22">2-2</td>
                      </tr>
                      <tr>
                        <td>Pangkat/NRP</td>
                        <td>:</td>
                        <td class="bag23">2-3</td>
                      </tr>
                      <tr>
                        <td>Jabatan</td>
                        <td>:</td>
                        <td class="bag21">2-1</td>
                      </tr>
                      <tr>
                        <td>Alamat</td>
                        <td>:</td>
                        <td class="bag25">2-5</td>
                      </tr>
                    </table>
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
                 url: "{{route('pilihBulanTahunLaporanKUSusulan')}}",
                data: 
                { 
                  "_token": "{{ csrf_token() }}",
                  "bulan" : bulan,
                  "tahun" : tahun,
                  "satker" : satker,
                  "jenis_pegawai" : jenis_pegawai,
                  "halaman" : "4",
                },
                success: function(data) {
                  $('.satkerNama').html(data.selectedSatker.nm_satker);
                  console.log(data);
                  //
                  //loop ttd
                  $.each(data.dataTTD,function(k,v){
                    if(v.bagian == "1")
                    {
                      $('.bag11').html(v.nilai1);
                      $('.bag12').html(v.nilai2);
                      $('.bag13').html(v.nilai3);
                      $('.bag14').html(v.nilai4);
                      $('.bag15').html(v.nilai5);
                    }
                    else if(v.bagian == "2")
                    {
                      $('.bag21').html(v.nilai1);
                      $('.bag22').html(v.nilai2);
                      $('.bag23').html(v.nilai3);
                      $('.bag24').html(v.nilai4);
                      $('.bag25').html(v.nilai5);
                    }
                    else if(v.bagian == "3")
                    {
                      $('.bag31').attr('data-word',v.nilai1);
                    }
                    
                  });
                  //
                  if(data.status == "nodata")
                  { 
                    $('.showWhenLoading').fadeOut("slow");
                    $('.lembarLaporanKU').fadeOut('slow');
                    $('#message').fadeIn("slow").html('Belum Ada Data Absensi');
                    setTimeout(function(){
                      $('#message').fadeOut('slow');
                    },3000)
                  }
                  if(data.dataAbsensi.length == 0)
                  { 
                    $('.showWhenLoading').fadeOut("slow");
                    $('.lembarLaporanKU').fadeOut('slow');
                    $('#message').fadeIn("slow").html('Belum Ada Data Absensi');
                    setTimeout(function(){
                      $('#message').fadeOut('slow');
                    },3000)
                  }
                  else if(data.status == "success")
                  {
                    $('.lembarLaporanKU').fadeIn("slow");
                    i = 1;
                    
                    mengenaiWord = data.words;                    
                    insertWord = $('.mengenai').attr('data-word').replace('[bulan]',mengenaiWord);
                    insertWord = insertWord.replace('[anggota]',data.anggota);
                    insertWord = insertWord.replace('[satker]',data.satkerNama);
                    $('.mengenai').html(insertWord);
                    

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

                    senilai2 = 0;
                    sprinLalu = 0;
                    sprinJumlah = 0;
                    sisaSprint = 0;
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
                    });
                    $('.senilai').html("Rp.   "+number_format(Math.ceil(jml12),0,",","."));
                    $('.terbilang').html('('+terbilang(Math.ceil(jml12))+')');
                    senilaiJumlah = jml12+senilai2;
                    $('.senilaiJumlah').html("Rp.   "+number_format(senilaiJumlah,0,",","."));
                    $('.sprinLalu').html("Rp.   "+number_format(sprinLalu,0,",","."));
                    sprinJumlah = sprinLalu+jml12;
                    $('.sprinJumlah').html("Rp.   "+number_format(sprinJumlah,0,",","."));
                    $('.sisaSprint').html("Rp.   "+number_format(sisaSprint,0,",","."));

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
