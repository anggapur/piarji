@extends('layouts.template')

@section('content')
    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-12 col-xs-6">
         @if (session('status'))
              <div class="alert alert-{{session('status')}}">
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
            <div class="box-header">              
              <h3 class="box-title">User</h3>                            
            </div>
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>                
                  <th>NRP/NIP</th>
                  <th>Nama Pegawai</th>                  
                  <th>Satker</th>                  
                  <th>Pangkat</th>                  
                  <th>Jabatan</th>                  
                  <th>No Rekening</th>                  
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
    <!-- /.content -->
    <script>
$(function() {
    $('#example1').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('getDataPegawai') !!}',
        columns: [
            { data: 'nip', name: 'nip' },                                  
            { data: 'nama', name: 'nama' },                        
            { data: 'nm_satker', name: 'satker.nm_satker' },                        
            { data: 'nm_pangkat', name: 'pangkat.nm_pangkat1' },                        
            { data: 'nm_jabatan', name: 'jabatan.nm_jabatan' },                        
            { data: 'no_rekening', name: 'no_rekening' },                        
                        
            /*{data: 'action', name: 'action', orderable: false, searchable: false}*/
        ]
    });
});


</script>
@endsection
