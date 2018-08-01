@extends('layouts.template')

@section('content')
    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-12 col-xs-6">         
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
                <form class="hide" id="formAbsensi">
                  <table id="example" class="display table table-bordered table-striped" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>NIP</th>
                            <th>Nama</th>
                             @foreach($dataAturanAbsensi as $val)     
                              <th class="col-xs-1 absensiColumn no-sort" style="width:10% !important">{{$val->nama}}</th>                  
                            @endforeach
                        </tr>
                    </thead>                   
                    <tbody>
                      @foreach($pegawai as $value)
                        <tr>
                           <td>{{$value->nip}}</td>                           
                            <td>{{$value->nama}}</td>     
                            <td><input type="number" name="absensi1" value="0" data="{{$value->nip}}" class="form-control" style="width:100px;" required /></td>                             
                            <td><input type="number" name="absensi2" value="0" data="{{$value->nip}}" class="form-control" style="width:100px;" required /></td>                             
                            <td><input type="number" name="absensi3" value="0" data="{{$value->nip}}" class="form-control" style="width:100px;" required /></td>                             
                            <td><input type="number" name="absensi4" value="0" data="{{$value->nip}}" class="form-control" style="width:100px;" required /></td>                             
                        </tr>
                      @endforeach                       
                    </tbody>
                  </table>                
                  <button id="get-result" class="btn btn-success">Simpan</button><br />
                  <textarea id="result-serialized" style="width: 200px; height: 100px;" class="hides"></textarea>
                  <textarea id="result-json" style="width: 200px; height: 100px;" class="hides"></textarea>  
                </form>
               
            </div>   
          </div>
          <!-- end box info -->
        </div>        
      </div>
      <!-- /.row -->
      
    </section>
    
   <script type="text/javascript">
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
          
          $.ajax({
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
                      $('#formBulanTahun').find('select,input').attr('disabled','disabled');
                      $('#formAbsensi').removeClass('hide');
                    }
                }
            });
          e.preventDefault();
        });

        //send data
        t = $('#example').DataTable( {
        "columnDefs": [ {
          "targets": 'no-sort',
          "orderable": false,
           "searchable": false,
            } ]
        } );
        $('#get-result').click(function(e) {
            e.preventDefault();
            ar = $()
            for (var i = 0; i < t.rows()[0].length; i++) { 
                ar = ar.add(t.row(i).node())
            }
            $('#result-serialized').val(ar.find('select,input,textarea').serialize());
               
            absensi1 = [];
            absensi2 = [];
            absensi3 = [];
            absensi4 = [];         
            ar.find('input').each(function(i, el) {    
              if($(el).attr('name') == "absensi1") 
              {
                  b = {
                    "id" : $(el).attr('data'),
                    "nilai" : $(el).val(),
                  };           
                  absensi1.push(b);
              }
              if($(el).attr('name') == "absensi2") 
              {
                  b = {
                    "id" : $(el).attr('data'),
                    "nilai" : $(el).val(),
                  };           
                  absensi2.push(b);
              }
              if($(el).attr('name') == "absensi3") 
              {
                  b = {
                    "id" : $(el).attr('data'),
                    "nilai" : $(el).val(),
                  };           
                  absensi3.push(b);
              }
              if($(el).attr('name') == "absensi4") 
              {
                  b = {
                    "id" : $(el).attr('data'),
                    "nilai" : $(el).val(),
                  };           
                  absensi4.push(b);
              }

            });
            json_obj.absensi[1] = absensi1;
            json_obj.absensi[2] = absensi2;
            json_obj.absensi[3] = absensi3;
            json_obj.absensi[4] = absensi4;
            $('#result-json').val(JSON.stringify(json_obj));

            //Kirim data melalui ajax
            $.ajax({
                type: "POST",                  
                url: "{{route('absensi.store')}}",
                data: 
                { 
                  "_token": "{{ csrf_token() }}",
                  "datas" : json_obj,
                },
                success: function(data) {
                    if(data.status == "success")
                    {
                      $("html,body").scrollTop($("body").scrollTop() + 0);
                      $('.alert.alert-success').slideDown(200);
                      setTimeout(function(){ 
                         $('.alert.alert-success').fadeOut(500);
                        }, 4000);
                      
                    }
                }
            });
            //unset data
            absensi1 = null;
            absensi2 = null;
            absensi3 = null;
            absensi4 = null;
        });
    });
   </script>
@endsection
