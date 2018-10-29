<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\pegawai;
use CH;
use Yajra\Datatables\Datatables;
use App\aturan_absensi;
use App\waktu_absensi;
use App\aturan_tunkin;
use App\absensiKekurangan;
class absensiKekuranganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $mainPage = "absensiKekurangan";
    public $page = "Absensi Kekurangan Pegawai";
    public function index()
    {
        //data
        if(Auth::user()->level == "admin")
        {
            $q = pegawai::leftJoin('satker','pegawai.kd_satker','=','satker.kd_satker')
            ->leftJoin('pangkat','pegawai.kd_pangkat','=','pangkat.kd_pangkat')            
            ->leftJoin('jabatan','pegawai.kd_jab','=','jabatan.kd_jabatan')            
            ->select('pegawai.*','satker.nm_satker','nm_pangkat1','nm_pangkat2','nm_jabatan');
        }
        else
        {
            $q = pegawai::leftJoin('satker','pegawai.kd_satker','=','satker.kd_satker')
            ->leftJoin('pangkat','pegawai.kd_pangkat','=','pangkat.kd_pangkat')            
            ->leftJoin('jabatan','pegawai.kd_jab','=','jabatan.kd_jabatan')   
            ->where('pegawai.kd_satker',CH::getKdSatker(Auth::user()->kd_satker))         
            ->select('pegawai.*','satker.nm_satker','nm_pangkat1','nm_pangkat2','nm_jabatan');
        }
        $data['pegawai'] = $q->get();
        //waktu absensi
        $data['tahunTerkecil'] = waktu_absensi::orderBy('tahun','ASC')->first()->tahun;        
        $data['dataAturanAbsensi'] = aturan_absensi::all();
        $data['page'] = $this->page;
        $data['subpage'] = ""; 
        // return CH::getKdSatker(Auth::user()->kd_satker);        
        return view($this->mainPage.".index",$data);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
      $count = 0;
        $where = ['bulan' => $request->datas['bulan'], 'tahun' => $request->datas['tahun']];
        $query = waktu_absensi::where($where)->first();
        $data = $request->datas;
        $data['idBulanTahun'] = $query->id;

        $datas = $request->datas['absensi'];
        $kdAnakSatker = $request->datas['kodeAnakSatker'];
        $kelasJab = $request->datas['kelasJab'];        
        $statusDapat = $request->datas['statusDapat'];        
        $stateTipikor = $request->datas['stateTipikor'];
        
        //kode aturan
        $kd_aturan = aturan_tunkin::where('state','2')->first();
        //proses pemasukan data
        foreach ($datas[1] as $key => $value) {
          try{
            $dataInsert['nip'] = $value['id'];
            $dataInsert['absensi1'] = $value['nilai'];
            $dataInsert['absensi2'] = $datas[2][$key]['nilai'];            
            $dataInsert['absensi3'] = $datas[3][$key]['nilai'];            
            $dataInsert['absensi4'] = $datas[4][$key]['nilai'];  
            $dataInsert['kd_anak_satker_saat_absensi'] = $kdAnakSatker[$key]['nilai'];
            $dataInsert['kelas_jab_saat_absensi'] = $kelasJab[$key]['nilai'];
            $dataInsert['status_dapat'] = $statusDapat[$key]['nilai'];
            $dataInsert['state_tipikor_saat_absensi'] = $stateTipikor[$key]['nilai'];
            $dataInsert['id_waktu'] = $data['idBulanTahun'];
            $dataInsert['kd_aturan'] = $kd_aturan->id;
            $dataInsert['kd_satker_saat_absensi'] = CH::getKdSatker(Auth::user()->kd_satker);
            //cari dulu 
            $querySearch = absensiKekurangan::where(['nip' => $value['id'], 'id_waktu' => $data['idBulanTahun']])->get();
            //insert
            if($querySearch->count() == 0)
                $queryProcess = absensiKekurangan::create($dataInsert);
            else
                $queryProcess = absensiKekurangan::where(['nip' => $value['id'], 'id_waktu' => $data['idBulanTahun']])->update($dataInsert);
            $count++;
            //cek query executed or not
            // if(!$queryProcess)
            //     return $dataInsert;
            }
            catch (\Illuminate\Database\QueryException $exception) {
    // You can check get the details of the error using `errorInfo`:
    $errorInfo = $exception->errorInfo;
return $errorInfo;
    // Return the response to the client..
}
        }

        return ['status' => 'success','kd_aturan' => $kd_aturan,'sisa_data' => $request->sisa_data,'data_yang_diproses' => $count];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function anyData()
    {
        if(Auth::user()->level == "admin")
        {
            $q = pegawai::leftJoin('satker','pegawai.kd_satker','=','satker.kd_satker')
            ->leftJoin('pangkat','pegawai.kd_pangkat','=','pangkat.kd_pangkat')            
            ->leftJoin('jabatan','pegawai.kd_jab','=','jabatan.kd_jabatan')            
            ->select('pegawai.*','satker.nm_satker','nm_pangkat1','nm_pangkat2','nm_jabatan');
        }
        else
        {
            $q = pegawai::leftJoin('satker','pegawai.kd_satker','=','satker.kd_satker')
            ->leftJoin('pangkat','pegawai.kd_pangkat','=','pangkat.kd_pangkat')            
            ->leftJoin('jabatan','pegawai.kd_jab','=','jabatan.kd_jabatan')   
            ->where('pegawai.kd_satker',CH::getKdSatker(Auth::user()->kd_satker))         
            ->select('pegawai.*','satker.nm_satker','nm_pangkat1','nm_pangkat2','nm_jabatan');
        }
        return Datatables::of($q)
            ->addColumn('action', function ($user) {
                return '<input type="number" value="0" class="form-control" name="absensi1[]">';
            })
            ->addColumn('action2', function ($user) {
                  return '<input type="number" value="0" class="form-control" name="absensi2[]">';
            })
            ->addColumn('action3', function ($user) {
                  return '<input type="number" value="0" class="form-control" name="absensi3[]">';
            })
            ->addColumn('action4', function ($user) {
                  return '<input type="number" value="0" class="form-control" name="absensi4[]">';
            })
             ->rawColumns(['action','action2','action3','action4'])
            ->make(true);
    }
    /*
    public function pilihBulanTahun(Request $request)
    {
        //cari data yang sesuai
        $where = ['bulan' => $request->bulan, 'tahun' => $request->tahun];
        $query = waktu_absensi::where($where)->get();
        if($query->count() == 0)
        {
            //buat data jika tidak ada
            $q = waktu_absensi::create($where);
            return ['idBulanTahun' => $q->id,'status' => 'success','dataAbsensi' => null];
        }
        else if($query->count() == 1)
        {
            $q2 = absensi::where('id_waktu',$query[0]['id'])
                    ->where('absensi.kd_satker_saat_absensi',CH::getKdSatker(Auth::user()->kd_satker))            
                    ->select('id','nip','id_waktu','absensi1','absensi2','absensi3','absensi4')->get();
            return ['idBulanTahun' => $query[0]['id'],'status' => 'success','dataAbsensi' => $q2];            
        }
        else
        {
            return ['status' => 'failed'];
        }
    }
    */

    public function pilihBulanTahunPegawai(Request $request)
    {
        //cari data yang sesuai
        $where = ['bulan' => $request->bulan, 'tahun' => $request->tahun,'absensi_kekurangan.kd_satker_saat_absensi' => CH::getKdSatker(Auth::user()->kd_satker)];
        $query = waktu_absensi::where($where)->join('absensi_kekurangan','waktu_absensi.id','=','absensi_kekurangan.id_waktu');
        if($query->get()->count() == 0)
        {

          $qu = waktu_absensi::where(['bulan' => $request->bulan, 'tahun' => $request->tahun]);
          
          if($qu->get()->count() == 0)
            $q = waktu_absensi::create(['bulan' => $request->bulan, 'tahun' => $request->tahun]);

            $data = pegawai::where('pegawai.kd_satker',CH::getKdSatker(Auth::user()->kd_satker))
                    ->orderBy('kelas_jab','DESC')
                    ->where('status_aktif','1')        
            ->get();
            return ['keterangan' => 'Tidak Ada Pegawai','data' => $data];
        }
        else if($query->get()->count() > 0)
        {
          $qWaktu = waktu_absensi::where(['bulan' => $request->bulan, 'tahun' => $request->tahun])->first();
            $data =  absensiKekurangan::where('absensi_kekurangan.kd_satker_saat_absensi',CH::getKdSatker(Auth::user()->kd_satker))              
              ->leftJoin('pegawai','absensi_kekurangan.nip','=','pegawai.nip')
              ->orderBy('kelas_jab','DESC')
              ->where('id_waktu',$qWaktu->id)
              ->select('absensi_kekurangan.*','pegawai.nama');            
            return ['keterangan' => ' Ada Pegawai','data' => $data->get(),'id_waktu' => $qWaktu->id];
        }
        else
        {
            return ['status' => 'failed'];
        }
    }
}
