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
                  <th>No</th>
                  <th>NIP</th>
                  <th>Nama</th>
                  <th>Dari Satker</th>
                  <th>Waktu Keluar dari Satker Terdahulu</th>
                  <th>Status Terima</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                  @foreach($dataMutasi as $val)    
                    <tr>
                      <td>{{$loop->iteration}}</td>
                      <td>{{$val->nip}}</td>
                      <td>{{$val->nama}}                          
                      </td>
                      <td>
                        @if($val->ke_satker !== "out")
                          {{$val->dari_satker}} - {{$val->nm_satker}}
                        @else
                          <span class="label label-danger">Keluar Polda</span>
                        @endif
                      </td>
                      <td>{{$bulan[$val->bulan_keluar]}} {{$val->tahun_keluar}}</td>
                      <td>
                        @if($val->ke_satker !== "out")
                          @if($val->status_terima == 0)
                            <span class="label label-warning">Belum Diterima</span>
                          @elseif($val->status_terima == 1)
                            <span class="label label-success">Sudah Diterima - 
                            {{$bulan[$val->bulan_diterima]}} {{$val->tahun_diterima}}</span>
                          @endif
                        @else
                          -
                        @endif
                      </td>
                      <td>
                        @if($val->ke_satker !== "out")
                          @if($val->status_terima == 0)
                             <button type="button" class="btn btn-success btn-xs btnTerima" data-nip="{{$val->nip}}" data-nama="{{$val->nama}}" data-id="{{$val->id}}" data-toggle="modal" data-target="#myModal">Terima</button>
                          @elseif($val->status_terima == 1)
                            -                            
                          @endif
                        @else
                           <button type="button" class="btn btn-success btn-xs btnTerima" data-nip="{{$val->nip}}" data-nama="{{$val->nama}}" data-id="{{$val->id}}" data-toggle="modal" data-target="#myModal">Terima</button>
                        @endif
                      </td>
                    </tr>
                  @endforeach
                </tbody>                
              </table>
                             
            </div>           
          </div>
          <!-- end box info -->
        </div>        
      </div>
      <!-- /.row -->
      
    </section>

    <!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Terima Mutasi Pegawai</h4>
      </div>
      <div class="modal-body">
        <form method="post" action="{{url('mutasiSetting/terima')}}">
          {{csrf_field()}}          
            <input type="hidden" name="id">          
          <div class="form-group">
            <label>NIP</label>
            <input type="" name="nip" class="form-control" value="" readonly>
          </div>
          <div class="form-group">
            <label>Nama</label>
            <input type="" name="nama" class="form-control" value="" readonly>
          </div>
          <div class="form-group dalam keluar">
            <label>Bulan Keluar</label>
            <select class="form-control" name="bulan_diterima" required="required">
              <option value="">-</option>
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
          <div class="form-group dalam keluar">
            <label>Tahun Keluar</label>
            <select class="form-control" name="tahun_diterima" required="required">
              <option value="">-</option>
              @for($i = $tahunTerkecil; $i <= date('Y')+1 ; $i++)
                <option value="{{$i}}">{{$i}}</option>
              @endfor
            </select>
          </div> 
          

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Terima Pegawai</button>
        </form>
      </div>
    </div>
  </div>
</div>
    <!-- /.content -->
   <script type="text/javascript">
     $('.btnTerima').click(function(){
      $('input[name="id"]').val($(this).attr('data-id'));
      $('input[name="nip"]').val($(this).attr('data-nip'));
      $('input[name="nama"]').val($(this).attr('data-nama'));
     });
   </script>
@endsection
