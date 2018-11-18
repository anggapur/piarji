@extends('layouts.template')

@section('content')
    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-12 col-xs-12">
         @if (session('status'))
              <div class="alert alert-success">
                  {!! session('message') !!}
              </div>
          @endif
           @if (session('status2'))
              <div class="alert alert-danger">
                  {!! session('message2') !!}
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
              <h3 class="box-title">Data Personil</h3>                            
              <a href="{{url('exportDataPegawai')}}" class="btn btn-success btn-xs" style="float: right;">Download Data Pegawai</a>
            </div>
            <div class="box-body">

              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>                
                  <th>NRP/NIP</th>
                  <th>Nama Pegawai</th>                  
                  <th>Satker</th>                  
                  <th>Pangkat</th>                  
                  <!-- <th>Jabatan</th>                   -->
                  <th>No Rekening</th>                  
                  <th>Status Aktif</th>                  
                  <th>Action</th>                  
                </tr>
                <tr>                
                  <th colspan="2">Cari Berdasarkan Satker</th>                                
                  <th>Satker</th>                  
                  <th colspan="5"></th>                 
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
            // { data: 'nm_jabatan', name: 'jabatan.nm_jabatan' },                        
            { data: 'no_rekening', name: 'no_rekening' },                        
            { data: 'status_aktif', name: 'status_aktif' },                        
            { data: 'action', name: 'action' },                        
                        
            /*{data: 'action', name: 'action', orderable: false, searchable: false}*/
        ],
         initComplete: function () {
            this.api().columns(2).every( function () {
                var column = this;
                var select = $('<select><option value=""></option></select>')
                    .appendTo( $(column.header()).empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
 
                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );
 
                column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                } );
            } );
        }
    });



});
function showAlert()
{
  //alert('Gagaga');
}

</script>
@endsection
