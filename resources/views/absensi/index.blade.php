@extends('layouts.template')

@section('content')
    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-12 col-xs-6">
         @if (session('status'))
              <div class="alert alert-success">
                  {!! session('message') !!}
              </div>
          @endif
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
              <h3 class="box-title">User</h3>                            
            </div>
            <div class="box-body">    
                  <table id="example" class="display table table-bordered table-striped" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>NIP</th>
                            <th>Nama</th>
                             @foreach($dataAturanAbsensi as $val)     
                              <th class="col-xs-1 absensiColumn" style="width:10% !important">{{$val->nama}}</th>                  
                            @endforeach
                        </tr>
                    </thead>                   
                    <tbody>
                      @foreach($pegawai as $value)
                        <tr>
                           <td>{{$value->nip}}</td>                           
                            <td>{{$value->nama}}</td>     
                            <td><input type="number" name="absensi1" value="0" data="{{$value->id}}" class="form-control" style="width:100px;" required /></td>                             
                            <td><input type="number" name="absensi2" value="0" data="{{$value->id}}" class="form-control" style="width:100px;" required /></td>                             
                            <td><input type="number" name="absensi3" value="0" data="{{$value->id}}" class="form-control" style="width:100px;" required /></td>                             
                            <td><input type="number" name="absensi4" value="0" data="{{$value->id}}" class="form-control" style="width:100px;" required /></td>                             
                        </tr>
                      @endforeach                       
                    </tbody>
                </table>
                <button id="get-result" class="btn btn-success">Simpan</button><br />
                <textarea id="result-serialized" style="width: 200px; height: 100px;" class="hides"></textarea>
                <textarea id="result-json" style="width: 200px; height: 100px;" class="hides"></textarea>  
            </div>   
          </div>
          <!-- end box info -->
        </div>        
      </div>
      <!-- /.row -->
      
    </section>
    
   <script type="text/javascript">
     $(function() {
        t = $('#example').DataTable();
        $('#get-result').click(function() {
            ar = $()
            for (var i = 0; i < t.rows()[0].length; i++) { 
                ar = ar.add(t.row(i).node())
            }
            $('#result-serialized').val(ar.find('select,input,textarea').serialize());
            
            json_obj = { 
              "absensi1" : null,
              "absensi2" : null,
              "absensi3" : null,
              "absensi4" : null,
            };            
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
            json_obj.absensi1 = absensi1;
            json_obj.absensi2 = absensi2;
            json_obj.absensi3 = absensi3;
            json_obj.absensi4 = absensi4;
            $('#result-json').val(JSON.stringify(json_obj));

           
            $.ajax({
                type: "POST",                  
                url: "{{route('absensi.store')}}",
                data: 
                { 
                  "_token": "{{ csrf_token() }}",
                  "datas" : json_obj,
                },
                success: function(data) {
                    console.log(data);
                }
            });
        });
    });
   </script>
@endsection
