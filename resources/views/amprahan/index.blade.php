@extends('layouts.template')

@section('content')
    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-12 col-xs-12">         
              <div class="alert alert-success" style="display: none;">
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
              <h3 class="box-title">Form Absensi</h3>                            
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
                <div class="form-group">
                  <input type="submit" name="submitBulanTahun" value="Pilih" class="btn btn-success" id="btnPilih">
                </div>
              </form>
              <hr>
                <form style="display: none;" id="formAbsensi">
                  <table  class="display table table-bordered table-striped" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>NIP</th>
                            <th>Nama</th>                                                        
                            <th>
                              Status
                            </th>
                        </tr>
                    </thead>                   
                    <tbody>
                      <!-- @foreach($pegawai as $value) -->
                       <!--  <tr>
                           <td>{{$value->nip}}</td>                           
                            <td>{{$value->nama}}</td>     
                            <td class="inputColumn"><input type="number" name="absensi1" value="0" data="{{$value->nip}}" class="form-control" style="width:100px;" required /></td>                             
                            <td class="inputColumn"><input type="number" name="absensi2" value="0" data="{{$value->nip}}" class="form-control" style="width:100px;" required /></td>                             
                            <td class="inputColumn"><input type="number" name="absensi3" value="0" data="{{$value->nip}}" class="form-control" style="width:100px;" required /></td>                             
                            <td class="inputColumn"><input type="number" name="absensi4" value="0" data="{{$value->nip}}" class="form-control" style="width:100px;" required /></td>                             
                        </tr> -->
                      <!-- @endforeach                        -->
                    </tbody>
                  </table>                
                  <button id="get-result" class="btn btn-success">Simpan</button><br />
                  <textarea id="result-serialized" style="width: 200px; height: 100px;display: none;" class="hides"></textarea>
                  <textarea id="result-json" style="width: 200px; height: 100px;display: none;" class="hides"></textarea>  
                </form>
               
            </div>   
          </div>
          <!-- end box info -->
        </div>        
      </div>
      <!-- /.row -->
      <div class="bgBlack showWhenLoading"></div>
    <div class="spinner showWhenLoading">
      <h3>Menyimpan Absensi</h3>
      <div class="bounce1"></div>
      <div class="bounce2"></div>
      <div class="bounce3"></div>
    </div>
    </section>
    
   <script type="text/javascript">
    var t;
     $(function() {
      //deklarasi var
      json_obj = { 
        "bulan" : null,
        "tahun" : null,
        "absensi" : [],                
      };                 

        //form bulan tahun
        $('#formBulanTahun').submit(function(e){
          bulan = $(this).find("select[name='bulan']").val();
          tahun = $(this).find("select[name='tahun']").val();
          $('#formAbsensi').fadeIn('slow');
          $('#formBulanTahun').find('select,input').attr('disabled','disabled');

          $.ajax({
                type: "POST",                  
                url: "{{route('pilihBulanTahunPegawaiAmprahan')}}",
                data: 
                { 
                  "_token": "{{ csrf_token() }}",
                  "bulan" : bulan,
                  "tahun" : tahun,
                },
                success: function(data){
                  console.log(data);
                  //alert(data);
                  $.each(data.data,function(k,v){
                    if(data.keterangan == "Tidak Ada Pegawai")
                    {
                      html = '<tr>'+
                           '<td>'+v.nip+'</td>'+                         
                            '<td>'+v.nama+
                            '<input type="hidden" name="kd_anak_satker" value="'+v.kd_anak_satker+'" data="'+v.nip+'" class="form-control" style="width:100px;" required />'+
                            '<input type="hidden" name="kelas_jab" value="'+v.kelas_jab+'" data="'+v.nip+'" class="form-control" style="width:100px;" required />'+
                            
                            '<input type="hidden" name="absensi1" value="0" data="'+v.nip+'" class="form-control" style="width:100px;" required />'+                                                        
                            '</td>'+        
                            '<td> <label class="switch"><input type="checkbox" name="statusDapat" data="'+v.nip+'" checked><span class="slider round"></span></label></td>'+                      
                        '</tr>';
                   
                    }
                    else
                    {

                      status_dapat = "";
                      if(v.status_dapat == "1")
                        status_dapat = "checked";

                       html = '<tr>'+
                           '<td>'+v.nip+'</td>'+                         
                            '<td>'+v.nama+
                            '<input type="hidden" name="kd_anak_satker" value="'+v.kd_anak_satker_saat_amprah+'" data="'+v.nip+'" class="form-control" style="width:100px;" required />'+
                            '<input type="hidden" name="kelas_jab" value="'+v.kelas_jab_saat_amprah+'" data="'+v.nip+'" class="form-control" style="width:100px;" required />'+

                            '<input type="hidden" name="absensi1" value="0" data="'+v.nip+'" class="form-control" style="width:100px;" required />'+
                            '</td>'+     
                                                    
                            '<td> <label class="switch"><input type="checkbox" name="statusDapat" data="'+v.nip+'" '+status_dapat+'><span class="slider round"></span></label></td>'+
                        '</tr>';                      
                    }
                      $('tbody').append(html);
                    });
                  
                  t = $('table').DataTable();
                }
              });
         /* $.ajax({
                type: "POST",                  
                url: "{{route('pilihBulanTahun')}}",
                data: 
                { 
                  "_token": "{{ csrf_token() }}",
                  "bulan" : bulan,
                  "tahun" : tahun,
                },
                success: function(data) {
                    console.log(data);
                    if(data.status == "success")
                    {                  
                      json_obj.bulan = bulan;    
                      json_obj.tahun = tahun;  
                      if(data.dataAbsensi !== null)  
                      {
                        arr = $();
                        for (var i = 0; i < t.rows()[0].length; i++) { 
                            arr = arr.add(t.row(i).node())
                        }
                        console.log(data.dataAbsensi);
                        $.each(data.dataAbsensi, function(k, v) {                          
                          arr.find('input[name="absensi1"][data="'+v.nip+'"]').val(v.absensi1);
                          arr.find('input[name="absensi2"][data="'+v.nip+'"]').val(v.absensi2);
                          arr.find('input[name="absensi3"][data="'+v.nip+'"]').val(v.absensi3);
                          arr.find('input[name="absensi4"][data="'+v.nip+'"]').val(v.absensi4);
                        });
                        
                      }                      
                      //
                      $('#formBulanTahun').find('select,input').attr('disabled','disabled');
                      $('#formAbsensi').fadeIn('slow');
                    }
                }
            });*/
          e.preventDefault();
        });

        //send data
        
        $('#get-result').click(function(e) {
          $('.showWhenLoading').fadeIn("slow");
            e.preventDefault();
            json_obj.bulan = bulan;    
            json_obj.tahun = tahun;  
            ar = $()
            for (var i = 0; i < t.rows()[0].length; i++) { 
                ar = ar.add(t.row(i).node())
            }
            $('#result-serialized').val(ar.find('select,input,textarea').serialize());
               
            absensi1 = [];            
            kodeAnakSatker = []; 
            kelasJab = [];     
            statusDapat = [];
            ar.find('input').each(function(i, el) {    
              if($(el).attr('name') == "absensi1") 
              {
                  b = {
                    "id" : $(el).attr('data'),
                    "nilai" : $(el).val(),
                  };           
                  absensi1.push(b);
              }
             
              if($(el).attr('name') == "kd_anak_satker") 
              {
                  b = {
                    "id" : $(el).attr('data'),
                    "nilai" : $(el).val(),
                  };           
                  kodeAnakSatker.push(b);
              }
              if($(el).attr('name') == "kelas_jab") 
              {
                  b = {
                    "id" : $(el).attr('data'),
                    "nilai" : $(el).val(),
                  };           
                  kelasJab.push(b);
              }
              if($(el).attr('name') == "statusDapat") 
              {
                if($(el).is(":checked"))
                {
                  b = {
                    "id" : $(el).attr('data'),
                    "nilai" : "1",
                  };         
                }
                else
                {
                  b = {
                    "id" : $(el).attr('data'),
                    "nilai" : "0",
                  };    
                }
                statusDapat.push(b);
              }

            });
            console.log(absensi1);
            json_obj.absensi[1] = absensi1;            
            json_obj.kodeAnakSatker = kodeAnakSatker;
            json_obj.kelasJab = kelasJab;
            json_obj.statusDapat = statusDapat;
            $('#result-json').val(JSON.stringify(json_obj));

            //Kirim data melalui ajax
            console.log(json_obj);
            $.ajax({
                type: "POST",                  
                url: "{{route('amprahan.store')}}",
                data: 
                { 
                  "_token": "{{ csrf_token() }}",
                  "datas" : json_obj,
                },
                success: function(data) {
                  console.log(data);
                    if(data.status == "success")
                    {
                      $("html,body").scrollTop($("body").scrollTop() + 0);
                      $('.alert.alert-success').slideDown(200);
                      setTimeout(function(){ 
                         $('.alert.alert-success').fadeOut(500);
                        }, 4000);
                      
                    }
                    $('.showWhenLoading').fadeOut("slow");
                }
            });
            //unset data
            absensi1 = null;
            
            kodeAnakSatker = null;
            kelasJab = null;
        });
    });
   </script>
@endsection
