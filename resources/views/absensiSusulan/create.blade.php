@extends('layouts.template')

@section('content')
    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-12 col-xs-6">
          @if(session('status'))
          <div class="alert alert-{{session('status')}}">
              {{session('message')}}
          </div>
          @endif
          <div class="alert alert-success" style="display: none;">
            
          </div>
          <div class="alert alert-danger" style="display: none;">
            
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
            <div class="box-header">              
              <!-- <h3 class="box-title">Form Absensi Susulan</h3>               -->
              <!-- /. tools -->
              <form id="formPilihPegawai">
                <div class="row">
                  <div class="col-md-5">
                    
                      <div class="row">
                        <div class="col-md-5">
                          <div class="form-group">
                            <label>Bulan</label>
                            <select class="form-control cond1" name="bulan" id="dateBulan">
                             {!!CH::printBulan()!!}
                            </select>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label>Tahun</label>
                            <select class="form-control cond1" name="tahun" id="dateTahun">
                              @for($i = $tahunTerkecil; $i <= date('Y')+1 ; $i++)
                                <option value="{{$i}}">{{$i}}</option>
                              @endfor
                            </select>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <button style="margin-top: 25px;" type="button" value="Pilih Bulan" class="btn btn-success cond1" id="btnPilih">Pilih Bulan</button>
                          </div>
                        </div>
                      </div>
                    
                  </div>

                  <div class="col-md-5">
                    <form>
                    <div class="form-group dalam keluar">
                      <label>Cari Pegawai</label>
                      <select class="js-example-basic-single form-control cond2" name="nip" required>                    
                        <option value="">-</option>
                        @foreach($dataPegawai as $val)
                          <option value="{{$val->nip}}" data-nama="{{$val->nama}}" data-kd-anak-satker="{{$val->kd_anak_satker}}" data-kelas-jab="{{$val->kelas_jab}}">{{$val->nip." - ".$val->nama}}</option>                                        
                        @endforeach
                      </select>                 
                    </div>          
                  </div>
                  <div class="col-md-2">
                    <div class="form-group dalam keluar">                      
                      <input type="submit" name="submit" class="btn btn-success cond2" value="Pilih Pegawai" style="margin-top: 25px;">
                    </div>
                  </form>
                  </div>

                </div>                
              </form>
            </div>
            <div class="box-body">
              <form method="POST" action="{{route('absensiSusulan.store')}}">                
                {{csrf_field()}}
                <input type="hidden" name="bulan">
                <input type="hidden" name="tahun">
                <input type="hidden" name="waktu_absensi">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>NIP</th>
                      <th>Nama</th>
                      <th>Kelas Jabatan</th>
                      @foreach($fieldAbsensi as $val)
                      <th style="width:100px;">{{$val->nama}}</th>
                      @endforeach
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    
                  </tbody>
                </table>
                <div class="form-group">
                  <input type="submit" name="" class="btn btn-success cond3" value="Simpan Absensi Susulan" >
                </div>
              </form>
            </div>
          </div>
        </div>        
      </div>
      <!-- /.row -->
      
    </section>
    <!-- Modal -->
    <div class="modal fade" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <form id="formUpdateKelasJabatan">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Edit Data Personil Untuk Absensi Susulan</h4>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <label>NIP</label>
                <input type="number" name="" readonly="readonly" value="" id="modalNip" class="form-control">
              </div>
              <div class="form-group">
                <label>Nama</label>
                <input type="text" name="" readonly="readonly" value="" id="modalNama" class="form-control">
              </div>
              <div class="form-group">
                <label>Kelas Jabatan</label>
                <select class="form-control" id="modalKelasJabatan" data="">
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                  <option value="6">6</option>
                  <option value="7">7</option>
                  <option value="8">8</option>
                  <option value="9">9</option>
                  <option value="10">10</option>
                  <option value="11">11</option>
                  <option value="12">12</option>
                  <option value="13">13</option>
                  <option value="14">14</option>
                  <option value="15">15</option>
                  <option value="16">16</option>
                </select>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary" >Update Data Amprahan</button>
            </div>
          </form>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- End Modal -->
    <!-- /.content -->
    <script type="text/javascript">
       function ubahKelasJab(nip,nama)
      {
        // alert(nip);
        kelas_jab = $('input[name="kelas_jab['+nip+']"][data="'+nip+'"]').val();
        $('#modalNip').val(nip);
        $('#modalNama').val(nama);
        $('#modalKelasJabatan').val(kelas_jab);
        $('#modalKelasJabatan').attr('data',nip);
        $('.modal').modal('show');
      }

      $('.cond2, .cond3').attr('disabled','disabled');
      dataPegawaiTerpilih = [];
      $(document).ready(function(){
        $('#formUpdateKelasJabatan').submit(function(e){
          dataNip = $('#modalKelasJabatan').attr('data');
          dataKelasJabatan = $('#modalKelasJabatan').val();
          // alert(dataNip+" "+dataKelasJabatan);
          //update datanya 
          // alert('.hoverCursor[data="'+dataNip+'"]');
          $('.hoverCursor[data="'+dataNip+'"]').html(dataKelasJabatan);
          $('input[name="kelas_jab['+dataNip+']"][data="'+dataNip+'"]').val(dataKelasJabatan);
          $('.modal').modal('hide');
          e.preventDefault();
        });
        //tahun
        $('#btnPilih').click(function(){
          
          bulan = $('#dateBulan').val();
          tahun = $('#dateTahun').val();          

          // alert(new Date(tahun,(bulan-1)));
          // alert(new Date());
          if(new Date(tahun,(bulan-1)) <= new Date())
          {
            $.ajax({
                type: "POST",                  
                url: "{{route('cekBulanTahun')}}",
                data: 
                { 
                  "_token": "{{ csrf_token() }}",
                  "bulan" : bulan,
                  "tahun" : tahun,
                },
                success: function(data) {
                  console.log(data);
                 
                      $.each(data.absensi,function(k,v){
                      //insert ke array
                      dataPegawaiTerpilih.push(v.nip);

                       html = '<tr data-nip="'+v.nip+'">'+
                        '<td>'+v.nip+'</td>'+
                        '<td>'+v.nama+
                         '<input type="hidden" name="kd_anak_satker['+v.nip+']" value="'+v.kd_anak_satker_saat_absensi+'" data="'+v.nip+'" class="form-control" style="width:100px;" required />'+
                            '<input type="hidden" name="kelas_jab['+v.nip+']" value="'+v.kelas_jab_saat_absensi+'" data="'+v.nip+'" class="form-control" style="width:100px;" required />'+
                        '</td>'+
                        '<td> <a class="hoverCursor" data="'+v.nip+'" onclick="ubahKelasJab(`'+v.nip+'`,`'+v.nama+'`)">'+v.kelas_jab_saat_absensi+'</a></td>'+
                        '<td><input type="number" min="0" name="absensi1['+v.nip+']" class="form-control" value="'+v.absensi1+'"></td>'+
                        '<td><input type="number" min="0" name="absensi2['+v.nip+']" class="form-control" value="'+v.absensi2+'"></td>'+
                        '<td><input type="number" min="0" name="absensi3['+v.nip+']" class="form-control" value="'+v.absensi3+'"></td>'+
                        '<td><input type="number" min="0" name="absensi4['+v.nip+']" class="form-control" value="'+v.absensi4+'"></td>'+
                        '<td>'+
                          '<a  class="btn btn-danger btn-xs" class"deleteField" onclick="deleteField('+v.nip+')">Hapus</a>'+
                        '</td>'+
                      '</tr>';
                      $('tbody').append(html);
                    });
                 

                  $('input[name="waktu_absensi"]').val(data.id_waktu_absensi);
                }
            });
            //bisa
            // alert('lebih kecil');
            $('input[name="bulan"]').val(bulan);
            $('input[name="tahun"]').val(tahun);
            $('.cond2,.cond3').removeAttr('disabled');
            $('.cond1').attr('disabled','disabled');
          }
          else
          {
            //tak bisa
            // alert('lebih besar');
            $('.alert').fadeOut();
            $('.alert-danger').fadeIn().html('Tidak bisa memilih waktu lebih besar dari bulan sekarang, absensi susulan hanya dapat dilakukan pada bulan sekarang dan lalu');
            setTimeout(function(){
              $('.alert').fadeOut();
            },2000);
          }
          
        });
        //
        $('#formPilihPegawai').submit(function(e){
          e.preventDefault();
          dataNip = $('select[name="nip"]').val();
          dataNama = $('select[name="nip"]').find(':selected').attr('data-nama');
          dataAnakSatker = $('select[name="nip"]').find(':selected').attr('data-kd-anak-satker');
          dataKelasJab = $('select[name="nip"]').find(':selected').attr('data-kelas-jab');
          console.log(dataNip+" "+dataNama);
          
          // dataPegawaiTerpilih[dataNip]['nip'] = dataNip;
          // dataPegawaiTerpilih[dataNip]['nama'] = dataNama;
          console.log(dataPegawaiTerpilih);
          if(dataPegawaiTerpilih.includes(dataNip))
          {
            $('.alert').hide();
            $('.alert.alert-danger').fadeIn().html('Pegawai Sudah Ada di Tabel');
            setTimeout(function(){
              $('.alert').fadeOut();
            },2000);

          }
          else
          {
            dataPegawaiTerpilih.push(dataNip);
            console.log('tidak ada');
            html = '<tr data-nip="'+dataNip+'">'+
                      '<td>'+dataNip+'</td>'+
                      '<td>'+dataNama+
                       '<input type="hidden" name="kd_anak_satker['+dataNip+']" value="'+dataAnakSatker+'" data="'+dataNip+'" class="form-control" style="width:100px;" required />'+
                            '<input type="hidden" name="kelas_jab['+dataNip+']" value="'+dataKelasJab+'" data="'+dataNip+'" class="form-control" style="width:100px;" required />'+
                      '</td>'+
                      '<td> <a class="hoverCursor" data="'+v.dataNip+'" onclick="ubahKelasJab(`'+dataNip+'`,`'+dataNama+'`)">'+dataKelasJab+'</a></td>'+
                      '<td><input type="number" min="0" name="absensi1['+dataNip+']" class="form-control" value="0"></td>'+
                      '<td><input type="number" min="0" name="absensi2['+dataNip+']" class="form-control" value="0"></td>'+
                      '<td><input type="number" min="0" name="absensi3['+dataNip+']" class="form-control" value="0"></td>'+
                      '<td><input type="number" min="0" name="absensi4['+dataNip+']" class="form-control" value="0"></td>'+
                      '<td>'+
                        '<a  class="btn btn-danger btn-xs" class"deleteField" onclick="deleteField('+dataNip+')">Hapus</a>'+
                      '</td>'+
                    '</tr>';
            $('tbody').append(html);

            $('tr[data-nip="'+dataNip+'"]').find('input[name="absensi1"]').focus();
          }

          // $('select[name="nip"]').val("");
          $('select[name="nip"]').val("").trigger('change');

        });
        //
        
      });

      function deleteField(nip)
      {
        $('tr[data-nip="'+nip+'"]').remove();
        return false;
      }
    </script>
@endsection
    