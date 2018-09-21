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
            <div class="box-header">              
              <h3 class="box-title">User</h3>                            
            </div>
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>                
                  <th>Kode Satker</th>
                  <th>Nama Satker</th>
                  <th>Anak Satker</th>
                  <th>Action</th>                  
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
        ajax: '{!! route('getDataSatker') !!}',
        columns: [
            { data: 'kd_satker', name: 'satker.kd_satker' },
            { data: 'nm_satker', name: 'satker.nm_satker' },                        
            { data: 'kolom_anak_satker', name: 'kolom_anak_satker' },                        
            
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });
});
</script>
@endsection
