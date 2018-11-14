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

    <div class="modal fade" tabindex="-1" role="dialog" id="modalDelete">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <form method="POST">
            <input type="hidden" name="_method" value="DELETE">
            {{csrf_field()}}
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Hapus Satker</h4>
            </div>
            <div class="modal-body">
              <p>Apakah anda yakin akan menhapus satker <b class="namaSatker"></b></p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-danger">Hapus Data Satker</button>
            </div>
          </form>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
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

function modalDelete(id)
{
  src = "{{url('dataSatker')}}/"+id;
   $('form').attr('action',src);
 
  dataNamaSatker = $('button[data-id="'+id+'"]').attr('data-nama-satker');
  $('.namaSatker').html(dataNamaSatker);
  $('#modalDelete').modal('toggle');

}
</script>
@endsection
