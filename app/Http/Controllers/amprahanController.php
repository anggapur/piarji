<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\pegawai;
use CH;
use App\waktu_absensi;
use App\aturan_absensi;
use App\amprahan;
use App\aturan_tunkin;

class amprahanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $mainPage = "amprahan";
    public $page = "Amprah Tunkin";
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
        $where = ['bulan' => $request->datas['bulan'], 'tahun' => $request->datas['tahun']];
        $query = waktu_absensi::where($where)->first();
        $data = $request->datas;
        $data['idBulanTahun'] = $query->id;

        $datas = $request->datas['absensi'];
        $kdAnakSatker = $request->datas['kodeAnakSatker'];
        $kelasJab = $request->datas['kelasJab'];        
        $statusDapat = $request->datas['statusDapat'];        
        
        //kode aturan
        $kd_aturan = aturan_tunkin::where('state','1')->first();
        //proses pemasukan data
        foreach ($datas[1] as $key => $value) {
          try{
            $dataInsert['nip'] = $value['id'];
            $dataInsert['kd_anak_satker_saat_amprah'] = $kdAnakSatker[$key]['nilai'];
            $dataInsert['kelas_jab_saat_amprah'] = $kelasJab[$key]['nilai'];
            $dataInsert['status_dapat'] = $statusDapat[$key]['nilai'];
            $dataInsert['id_waktu'] = $data['idBulanTahun'];
            $dataInsert['kd_aturan'] = $kd_aturan->id;
            $dataInsert['kd_satker_saat_amprah'] = CH::getKdSatker(Auth::user()->kd_satker);
            //cari dulu 
            $querySearch = amprahan::where(['nip' => $value['id'], 'id_waktu' => $data['idBulanTahun']])->get();
            //insert
            if($querySearch->count() == 0)
                $queryProcess = amprahan::create($dataInsert);
            else
                $queryProcess = amprahan::where(['nip' => $value['id'], 'id_waktu' => $data['idBulanTahun']])->update($dataInsert);

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

        return ['status' => 'success','kd_aturan' => $kd_aturan];
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
     public function pilihBulanTahunPegawai(Request $request)
    {
        //cari data yang sesuai
        $where = ['bulan' => $request->bulan, 'tahun' => $request->tahun,'amprahan.kd_satker_saat_amprah' => CH::getKdSatker(Auth::user()->kd_satker)];
        $query = waktu_absensi::where($where)->join('amprahan','waktu_absensi.id','=','amprahan.id_waktu');
        if($query->get()->count() == 0)
        {

          $qu = waktu_absensi::where(['bulan' => $request->bulan, 'tahun' => $request->tahun]);
          
          if($qu->get()->count() == 0)
            $q = waktu_absensi::create(['bulan' => $request->bulan, 'tahun' => $request->tahun]);

            $data = pegawai::where('pegawai.kd_satker',CH::getKdSatker(Auth::user()->kd_satker)) 
                    ->where('status_aktif','1')        
            ->get();
            return ['keterangan' => 'Tidak Ada Pegawai','data' => $data];
        }
        else if($query->get()->count() > 0)
        {
          $qWaktu = waktu_absensi::where(['bulan' => $request->bulan, 'tahun' => $request->tahun])->first();
            $data =  amprahan::where('amprahan.kd_satker_saat_amprah',CH::getKdSatker(Auth::user()->kd_satker))
              ->where('id_waktu',$qWaktu->id)
              ->leftJoin('pegawai','amprahan.nip','=','pegawai.nip');            
            return ['keterangan' => ' Ada Pegawai','data' => $data->get(),'id_waktu' => $qWaktu->id];
        }
        else
        {
            return ['status' => 'failed'];
        }
    }
}

