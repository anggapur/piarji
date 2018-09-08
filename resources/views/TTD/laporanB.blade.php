@extends('layouts.template')

@section('content')
    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-12 col-xs-12">   
          @if(session('status'))      
              <div class="alert alert-{{session('status')}}">
                  {{session('message')}}
              </div>         
          @endif 
           <div class="alert alert-success" id="alertDynamic" style="display: none">
                  
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
          <div class="box box-info noprint" >
            <!-- <form method="POST" action="{{route('absensi.store')}}">   -->
              {{csrf_field()}}
            <div class="box-header">              
              <h3 class="box-title">TTD Laporan B1 Polri & B2 PNS</h3>                            
            </div>
            <div class="box-body">   
            <div class="row"> 
              <form method="POST" action="{{url('tandaTanganSetting/saveData')}}" enctype="multipart/form-data">
                {{csrf_field()}}
                @if($dataTTD->count() !== 0)
                <div class="col-md-4">    
                  <h4>Tanda Tangan 1</h4>          
                  <div class="form-group">    
                    <label>Jabatan</label>
                    <input type="text" name="data[2][1][nilai1]" class="form-control" placeholder="Jabatan" value="{{collect($dataTTD)->firstWhere('bagian','1')->nilai1}}" required>
                  </div>
                  <div class="form-group">    
                    <label>Nama</label>
                    <input type="text" name="data[2][1][nilai2]" class="form-control" placeholder="Nama" value="{{collect($dataTTD)->firstWhere('bagian','1')->nilai2}}" required>
                  </div>
                  <div class="form-group">    
                    <label>Pangkat</label>
                    <input type="text" name="data[2][1][nilai3]" class="form-control" placeholder="Pangkat" value="{{collect($dataTTD)->firstWhere('bagian','1')->nilai3}}" required>
                  </div>
                  <div class="form-group">
                    <label>TTD</label>
                    <input type="file" name="image1" class="form-control">
                    <div class="wrapTTD">
                      @if(collect($dataTTD)->firstWhere('bagian','1')->image != "")
                      <span><i class="fa fa-trash deleteImage" data-id="{{collect($dataTTD)->firstWhere('bagian','1')->id}}"></i></span>
                      
                      <img src="{{url('public/images').'/'.collect($dataTTD)->firstWhere('bagian','1')->image}}" class="img-responsive" alt="Tidak Ada Gambar" data-id="{{collect($dataTTD)->firstWhere('bagian','1')->id}}">
                      @endif
                    </div>
                  </div>
                </div>
                
                <div class="col-md-4">     
                  <h4>Tanda Tangan 3</h4> 
                  <div class="form-group">    
                    <label>Waktu</label>
                    <input type="text" name="data[2][2][nilai4]" class="form-control" placeholder="Waktu" value="{{collect($dataTTD)->firstWhere('bagian','2')->nilai4}}" required>
                  </div>                     
                  <div class="form-group">    
                    <label>Jabatan</label>
                    <input type="text" name="data[2][2][nilai1]" class="form-control" placeholder="Jabatan" value="{{collect($dataTTD)->firstWhere('bagian','2')->nilai1}}" required>
                  </div>
                  <div class="form-group">    
                    <label>Nama</label>
                    <input type="text" name="data[2][2][nilai2]" class="form-control" placeholder="Nama" value="{{collect($dataTTD)->firstWhere('bagian','2')->nilai2}}" required>
                  </div>
                  <div class="form-group">    
                    <label>Pangkat</label>
                    <input type="text" name="data[2][2][nilai3]" class="form-control" placeholder="Pangkat" value="{{collect($dataTTD)->firstWhere('bagian','2')->nilai3}}" required>
                  </div>
                   <div class="form-group">
                    <label>TTD</label>
                    <input type="file" name="image2" class="form-control">
                      <div class="wrapTTD">
                        @if(collect($dataTTD)->firstWhere('bagian','2')->image != "")
                        <span><i class="fa fa-trash deleteImage" data-id="{{collect($dataTTD)->firstWhere('bagian','2')->id}}"></i></span>
                        
                       <img src="{{url('public/images').'/'.collect($dataTTD)->firstWhere('bagian','2')->image}}" class="img-responsive" alt="Tidak Ada Gambar" data-id="{{collect($dataTTD)->firstWhere('bagian','2')->id}}">
                       @endif
                      </div>
                  </div>
                </div>
                @else
                <div class="col-md-4">    
                  <h4>Tanda Tangan 1</h4>          
                  <div class="form-group">    
                    <label>Jabatan</label>
                    <input type="text" name="data[2][1][nilai1]" class="form-control" placeholder="Jabatan" value="" required>
                  </div>
                  <div class="form-group">    
                    <label>Nama</label>
                    <input type="text" name="data[2][1][nilai2]" class="form-control" placeholder="Nama" value="" required>
                  </div>
                  <div class="form-group">    
                    <label>Pangkat</label>
                    <input type="text" name="data[2][1][nilai3]" class="form-control" placeholder="Pangkat" value="" required>
                  </div>
                  <div class="form-group">
                    <label>TTD</label>
                    <input type="file" name="image1" class="form-control">                    
                  </div>
                </div>
             
                <div class="col-md-4">     
                  <h4>Tanda Tangan 3</h4> 
                   <div class="form-group">    
                    <label>Waktu</label>
                    <input type="text" name="data[2][2][nilai4]" class="form-control" placeholder="Waktu" value="" required>
                  </div>                  
                  <div class="form-group">    
                    <label>Jabatan</label>
                    <input type="text" name="data[2][2][nilai1]" class="form-control" placeholder="Jabatan" value="" required>
                  </div>
                  <div class="form-group">    
                    <label>Nama</label>
                    <input type="text" name="data[2][2][nilai2]" class="form-control" placeholder="Nama" value="" required>
                  </div>
                  <div class="form-group">    
                    <label>Pangkat</label>
                    <input type="text" name="data[2][2][nilai3]" class="form-control" placeholder="Pangkat" value="" required>
                  </div>
                  <div class="form-group">
                    <label>TTD</label>
                    <input type="file" name="image2" class="form-control">
                    
                  </div>
                </div>
                @endif
                <div class="col-md-12">
                  <input type="submit" name="submitForm" class="btn btn-success" value="Simpan">
                </div>
              </form>
            </div>
            </div>
          </div>
           
          <!-- end box info -->
        </div>        
      </div>
      <!-- /.row -->
      
    </section>
  
   <script type="text/javascript">     
    $(document).ready(function(){
      $('.deleteImage').click(function(){
        //alert($(this).attr('data-id'));
        idImage = $(this).attr('data-id');
        $.ajax({
                type: "POST",                  
                url: "{{route('deleteImageTTD')}}",
                data: 
                { 
                  "_token": "{{ csrf_token() }}",
                  "id" : idImage,
                },
                success: function(data) {
                  
                    if(data.status == "success")
                    {
                      // alert('dihapus');
                      $('#alertDynamic').html('Berhasil Hapus Gambar');
                        $('#alertDynamic').fadeIn('slow');
                      setTimeout(function(){
                        $('#alertDynamic').fadeOut('slow');
                      },3000);
                        $('img[data-id="'+idImage+'"]').fadeOut();
                    }
                }
            });
        $(this).fadeOut();
      });
    });
   </script>
@endsection
