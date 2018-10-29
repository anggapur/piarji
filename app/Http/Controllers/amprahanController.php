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
use App\satker;
use App\TTD;
use DB;
use Response;
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
        $kd_aturan = aturan_tunkin::where('state','1')->first();
        //proses pemasukan data
        foreach ($datas[1] as $key => $value) {
          try{
            $dataInsert['nip'] = $value['id'];
            $dataInsert['kd_anak_satker_saat_amprah'] = $kdAnakSatker[$key]['nilai'];
            $dataInsert['kelas_jab_saat_amprah'] = $kelasJab[$key]['nilai'];
            $dataInsert['status_dapat'] = $statusDapat[$key]['nilai'];
            $dataInsert['state_tipikor_saat_amprah'] = $stateTipikor[$key]['nilai'];
            // $dataInsert['state_tipikor_saat_amprah'] = pegawai::where('nip',$value['id'])->first()->state_tipikor;
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
                    ->orderBy('kelas_jab','DESC')
                    ->where('status_aktif','1')        
            ->get();
            return ['keterangan' => 'Tidak Ada Pegawai','data' => $data];
        }
        else if($query->get()->count() > 0)
        {
          $qWaktu = waktu_absensi::where(['bulan' => $request->bulan, 'tahun' => $request->tahun])->first();
            $data =  amprahan::where('amprahan.kd_satker_saat_amprah',CH::getKdSatker(Auth::user()->kd_satker))
                ->orderBy('kelas_jab','DESC')
                ->where('id_waktu',$qWaktu->id)
                ->leftJoin('pegawai','amprahan.nip','=','pegawai.nip');            
            return ['keterangan' => ' Ada Pegawai','data' => $data->get(),'id_waktu' => $qWaktu->id];
        }
        else
        {
            return ['status' => 'failed'];
        }
    }

    public function mintaTunkin()
    {
        $data['tahunTerkecil'] = waktu_absensi::orderBy('tahun','ASC')->first()->tahun;        
        $data['dataAturanAbsensi'] = aturan_absensi::all();
        $data['page'] = $this->page;
        $data['subpage'] = "Minta Tunkin"; 
        $data['dataTTD'] = TTD::where(['halaman' => '1','kd_satker' => Auth::user()->kd_satker])->get();
        $data['dataSatker'] = [];
        if(Auth::user()->level == "admin")
            $data['dataSatker'] = satker::select('id','kd_satker','nm_satker')->get();
        // return CH::getKdSatker(Auth::user()->kd_satker);        
        return view($this->mainPage.".mintaTunkin",$data);
    }
    public function apiMintaTunkin(Request $request)
    {
        $listBulan = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];

        $bulan = $request->bulan;
        $tahun = $request->tahun;
        // $satker = "S1";
        // $jenis_pegawai = "";

        $where['bulan'] = $bulan;
        $where['tahun'] = $tahun;
        $cariWaktu = waktu_absensi::where($where);
        if($cariWaktu->get()->count() == 0)        
        {
            return ['status' => 'nodata'];
        }
        else
        {
            
            $data = satker::
                    withCount(['getDataAmprahanPolri' => function($q) use ($request,$cariWaktu){
                        $q->whereRaw('LENGTH(amprahan.nip) <= 8')
                        ->where('amprahan.status_dapat','1')
                        ->where('amprahan.state_tipikor_saat_amprah',$request->stateTipikor)
                        ->where('id_waktu',$cariWaktu->first()->id);
                    }])
                    ->with(['getDataAmprahanPolri' => function($q) use ($request,$cariWaktu){
                        $q->whereRaw('LENGTH(amprahan.nip) <= 8')
                        ->leftJoin('aturan_tunkin_detail',function($q){
                            $q->on('amprahan.kelas_jab_saat_amprah','=','aturan_tunkin_detail.kelas_jabatan'); // ini minta diganti juga
                            $q->on('aturan_tunkin_detail.id_aturan_tunkin','=','amprahan.kd_aturan');
                        })
                        ->leftJoin('pegawai','amprahan.nip','=','pegawai.nip')
                        ->where('amprahan.status_dapat','1')
                        ->where('amprahan.state_tipikor_saat_amprah',$request->stateTipikor)
                        ->where('id_waktu',$cariWaktu->first()->id)
                        ->select(DB::raw('amprahan.*,tunjangan,pegawai.kawin,pegawai.tanggungan,pegawai.jenis_kelamin,pegawai.gapok,pegawai.tunj_strukfung,pegawai.tunj_lain'));
                    }])
                    ->withCount(['getDataAmprahanPns' => function($q) use ($request,$cariWaktu){
                        $q->whereRaw('LENGTH(amprahan.nip) > 8')
                        ->where('amprahan.status_dapat','1')
                        ->where('amprahan.state_tipikor_saat_amprah',$request->stateTipikor)
                        ->where('id_waktu',$cariWaktu->first()->id);
                    }])
                    ->with(['getDataAmprahanPns' => function($q) use ($request,$cariWaktu){
                        $q->whereRaw('LENGTH(amprahan.nip) > 8')
                        ->leftJoin('aturan_tunkin_detail',function($q){
                            $q->on('amprahan.kelas_jab_saat_amprah','=','aturan_tunkin_detail.kelas_jabatan'); // ini minta diganti juga
                            $q->on('aturan_tunkin_detail.id_aturan_tunkin','=','amprahan.kd_aturan');
                        })
                        ->leftJoin('pegawai','amprahan.nip','=','pegawai.nip')
                        ->where('amprahan.status_dapat','1')
                        ->where('amprahan.state_tipikor_saat_amprah',$request->stateTipikor)
                        ->where('id_waktu',$cariWaktu->first()->id)
                        ->select(DB::raw('amprahan.*,tunjangan,pegawai.kawin,pegawai.tanggungan,pegawai.jenis_kelamin,pegawai.gapok,pegawai.tunj_strukfung,pegawai.tunj_lain'));
                    }])
                    ->orderBy('id','ASC')
                    ->get();
            foreach ($data as $key => $value) {              
                foreach ($value->getDataAmprahanPolri as $key2 => $val) {
                    $val['pajak'] = intval(CH::formulaPPH($val->kawin,$val->tanggungan,$val->jenis_kelamin,$val->gapok,$val->tunj_strukfung,$val->tunjangan,$val->tunj_lain));
                }
                foreach ($value->getDataAmprahanPns as $key2 => $val) {
                    $val['pajak'] = intval(CH::formulaPPH($val->kawin,$val->tanggungan,$val->jenis_kelamin,$val->gapok,$val->tunj_strukfung,$val->tunjangan,$val->tunj_lain));
                }
                $value['sumPajakPolri'] = $value->getDataAmprahanPolri->sum('pajak');
                $value['sumDibayarkanPolri'] = $value->getDataAmprahanPolri->sum('tunjangan');
                $value['brutoPolri'] = $value['sumPajakPolri']+$value['sumDibayarkanPolri'];

                $value['sumPajakPns'] = $value->getDataAmprahanPns->sum('pajak');
                $value['sumDibayarkanPns'] = $value->getDataAmprahanPns->sum('tunjangan');
                $value['brutoPns'] = $value['sumPajakPns']+$value['sumDibayarkanPns'];
            }
            // foreach ($data as $key => $value) {
            //     echo $value->nm_satker."<br>";
            //     echo $value->getDataAmprahanPolri->sum('tunjangan')."<br><hr>";
            //     echo $value->getDataAmprahanPolri->count()."<br><hr>";
            //     foreach ($value->getDataAmprahanPolri as $key2 => $val) {
            //         echo $key2." ".$val->tunjangan.", pajak : ".$val->pajak."<br>";
            //     }
            // }
            // return Response::json($data, 200, array(), JSON_PRETTY_PRINT);
            return  ['status' => 'adadata','data' => $data,'bulan' => $listBulan[$bulan],'tahun' => $tahun];

        }
    }

    public function lbrKerja()
    {
        $data['tahunTerkecil'] = waktu_absensi::orderBy('tahun','ASC')->first()->tahun;        
        $data['dataAturanAbsensi'] = aturan_absensi::all();
        $data['page'] = $this->page;
        $data['subpage'] = "LBR KERJA"; 
        $data['dataTTD'] = TTD::where(['halaman' => '1','kd_satker' => Auth::user()->kd_satker])->get();
        $data['dataSatker'] = [];
        if(Auth::user()->level == "admin")
            $data['dataSatker'] = satker::select('id','kd_satker','nm_satker')->get();
        // return CH::getKdSatker(Auth::user()->kd_satker);        
        return view($this->mainPage.".lbrKerja",$data);
    }
    public function perKelasJabatan()
    {
        $data['tahunTerkecil'] = waktu_absensi::orderBy('tahun','ASC')->first()->tahun;        
        $data['dataAturanAbsensi'] = aturan_absensi::all();
        $data['page'] = $this->page;
        $data['subpage'] = "Perkelas Jabatan RTN"; 
        $data['dataTTD'] = TTD::where(['halaman' => '1','kd_satker' => Auth::user()->kd_satker])->get();
        $data['dataSatker'] = [];
        if(Auth::user()->level == "admin")
            $data['dataSatker'] = satker::select('id','kd_satker','nm_satker')->get();
        // return CH::getKdSatker(Auth::user()->kd_satker);        
        return view($this->mainPage.".perKelasJabatan",$data);
    }
    public function apiLbrKerja(Request $request)
    {
        $listBulan = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];

        $bulan = $request->bulan;
        $tahun = $request->tahun;
        // $satker = "S1";
        // $jenis_pegawai = "";

        $where['bulan'] = $bulan;
        $where['tahun'] = $tahun;
        $cariWaktu = waktu_absensi::where($where);
        if($cariWaktu->get()->count() == 0)        
        {
            return ['status' => 'nodata'];
        }
        else
        {
            
            $data = satker::
                    // withCount(['getDataAmprahanPolri' => function($q) use ($request){
                    //     $q->whereRaw('LENGTH(amprahan.nip) <= 8')
                    //     ->where('amprahan.status_dapat','1');
                    // }])
                    with(['getDataAmprahanPolri' => function($q) use ($cariWaktu){
                        $q->whereRaw('LENGTH(amprahan.nip) <= 8')
                        ->leftJoin('aturan_tunkin_detail',function($q){
                            $q->on('amprahan.kelas_jab_saat_amprah','=','aturan_tunkin_detail.kelas_jabatan'); // ini minta diganti juga
                            $q->on('aturan_tunkin_detail.id_aturan_tunkin','=','amprahan.kd_aturan');
                        })
                        ->orderBy('amprahan.kelas_jab_saat_amprah','DESC')
                        ->leftJoin('pegawai','amprahan.nip','=','pegawai.nip')
                        ->where('amprahan.status_dapat','1')
                        ->where('amprahan.state_tipikor_saat_amprah','0')
                        ->where('id_waktu',$cariWaktu->first()->id)
                        ->select(DB::raw('amprahan.*,tunjangan,pegawai.kawin,pegawai.tanggungan,pegawai.jenis_kelamin,pegawai.gapok,pegawai.tunj_strukfung,pegawai.tunj_lain'));
                    }])
                    // ->withCount(['getDataAmprahanPns' => function($q) use ($request){
                    //     $q->whereRaw('LENGTH(amprahan.nip) > 8')
                    //     ->where('amprahan.status_dapat','1');
                    // }])
                    ->with(['getDataAmprahanPns' => function($q) use ($cariWaktu){
                        $q->whereRaw('LENGTH(amprahan.nip) > 8')
                        ->leftJoin('aturan_tunkin_detail',function($q){
                            $q->on('amprahan.kelas_jab_saat_amprah','=','aturan_tunkin_detail.kelas_jabatan'); // ini minta diganti juga
                            $q->on('aturan_tunkin_detail.id_aturan_tunkin','=','amprahan.kd_aturan');
                        })
                        ->orderBy('amprahan.kelas_jab_saat_amprah','DESC')
                        ->leftJoin('pegawai','amprahan.nip','=','pegawai.nip')
                        ->where('amprahan.status_dapat','1')
                        ->where('amprahan.state_tipikor_saat_amprah','0')
                        ->where('id_waktu',$cariWaktu->first()->id)
                        ->select(DB::raw('amprahan.*,tunjangan,pegawai.kawin,pegawai.tanggungan,pegawai.jenis_kelamin,pegawai.gapok,pegawai.tunj_strukfung,pegawai.tunj_lain'));
                    }])

                    ->with(['getDataAmprahanTipidkor' => function($q) use ($cariWaktu){
                        // $q->whereRaw('LENGTH(amprahan.nip) > 8')
                        $q->leftJoin('aturan_tunkin_detail',function($q){
                            $q->on('amprahan.kelas_jab_saat_amprah','=','aturan_tunkin_detail.kelas_jabatan'); // ini minta diganti juga
                            $q->on('aturan_tunkin_detail.id_aturan_tunkin','=','amprahan.kd_aturan');
                        })
                        ->orderBy('amprahan.kelas_jab_saat_amprah','DESC')
                        ->leftJoin('pegawai','amprahan.nip','=','pegawai.nip')
                        ->where('amprahan.status_dapat','1')
                        ->where('amprahan.state_tipikor_saat_amprah','1')
                        ->where('id_waktu',$cariWaktu->first()->id)
                        ->select(DB::raw('amprahan.*,tunjangan,pegawai.kawin,pegawai.tanggungan,pegawai.jenis_kelamin,pegawai.gapok,pegawai.tunj_strukfung,pegawai.tunj_lain'));
                    }])
                    ->orderBy('id','ASC')
                    ->get();

                    foreach ($data as $key => $value) {  
                        // $value['listPolri'] = [16,15,14,13,12,11,10,9,8,7,6,5,4,3,2,1];
                        $value['getDataAmprahanPolriGroup'] = $value->getDataAmprahanPolri->groupBy('kelas_jab_saat_amprah');
                        foreach ($value['getDataAmprahanPolriGroup'] as $key2 => $val) {
                            foreach ($val as $key3 => $va) {
                                $va['pajak'] = intval(CH::formulaPPH($va->kawin,$va->tanggungan,$va->jenis_kelamin,$va->gapok,$va->tunj_strukfung,$va->tunjangan,$va->tunj_lain));
                            }
                            $val['jumlahOrang'] = $val->count();
                            $val['tunjangan'] = $val->sum('tunjangan') / $val['jumlahOrang'];
                            $val['jumlahPajak'] = $val->sum('pajak');
                            $val['jumlahTunjangan'] = $val->sum('tunjangan');
                        }
                        // $value['listPns'] = [16,15,14,13,12,11,10,9,8,7,6,5,4,3,2,1];
                        $value['getDataAmprahanPnsGroup'] = $value->getDataAmprahanPns->groupBy('kelas_jab_saat_amprah');
                        foreach ($value['getDataAmprahanPnsGroup'] as $key2 => $val) {
                            foreach ($val as $key3 => $va) {
                                $va['pajak'] = intval(CH::formulaPPH($va->kawin,$va->tanggungan,$va->jenis_kelamin,$va->gapok,$va->tunj_strukfung,$va->tunjangan,$va->tunj_lain));
                            }
                            $val['jumlahOrang'] = $val->count();
                            $val['tunjangan'] = $val->sum('tunjangan') / $val['jumlahOrang'];
                            $val['jumlahPajak'] = $val->sum('pajak');
                            $val['jumlahTunjangan'] = $val->sum('tunjangan');
                        }

                        //tipidkor
                        $value['getDataAmprahanTipidkorGroup'] = $value->getDataAmprahanTipidkor->groupBy('kelas_jab_saat_amprah');
                        foreach ($value['getDataAmprahanTipidkorGroup'] as $key2 => $val) {
                            foreach ($val as $key3 => $va) {
                                $va['pajak'] = intval(CH::formulaPPH($va->kawin,$va->tanggungan,$va->jenis_kelamin,$va->gapok,$va->tunj_strukfung,$va->tunjangan,$va->tunj_lain));
                            }
                            $val['jumlahOrang'] = $val->count();
                            $val['tunjangan'] = $val->sum('tunjangan') / $val['jumlahOrang'];
                            $val['jumlahPajak'] = $val->sum('pajak');
                            $val['jumlahTunjangan'] = $val->sum('tunjangan');
                        }
                    }

                    // return Response::json($data[0]->getDataAmprahanPolriGroup,200,array(),JSON_PRETTY_PRINT);
            // foreach ($data as $key => $value) {              
            //     foreach ($value->getDataAmprahanPolri as $key2 => $val) {
            //         $val['pajak'] = CH::formulaPPH($val->kawin,$val->tanggungan,$val->jenis_kelamin,$val->gapok,$val->tunj_strukfung,$val->tunjangan,$val->tunj_lain);
            //     }
            //     foreach ($value->getDataAmprahanPns as $key2 => $val) {
            //         $val['pajak'] = CH::formulaPPH($val->kawin,$val->tanggungan,$val->jenis_kelamin,$val->gapok,$val->tunj_strukfung,$val->tunjangan,$val->tunj_lain);
            //     }               
            // }
            // foreach ($data as $key => $value) {
            //     echo $value->nm_satker."<br>";
            //     echo $value->getDataAmprahanPolri->sum('tunjangan')."<br><hr>";
            //     echo $value->getDataAmprahanPolri->count()."<br><hr>";
            //     foreach ($value->getDataAmprahanPolri as $key2 => $val) {
            //         echo $key2." ".$val->tunjangan.", pajak : ".$val->pajak."<br>";
            //     }
            // }
            // return Response::json($data, 200, array(), JSON_PRETTY_PRINT);
            return  ['status' => 'adadata','data' => $data,'bulan' => $listBulan[$bulan],'tahun' => $tahun];

        }
    }
    public function apiPerKelasJabatan(Request $request)
    {
        $listBulan = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];

        $bulan = $request->bulan;
        $tahun = $request->tahun;
        // $satker = "S1";
        // $jenis_pegawai = "";

        $where['bulan'] = $bulan;
        $where['tahun'] = $tahun;
        $cariWaktu = waktu_absensi::where($where);
        if($cariWaktu->get()->count() == 0)        
        {
            return ['status' => 'nodata'];
        }
        else
        {
            
            $data = satker::
                    // withCount(['getDataAmprahanPolri' => function($q) use ($request){
                    //     $q->whereRaw('LENGTH(amprahan.nip) <= 8')
                    //     ->where('amprahan.status_dapat','1');
                    // }])
                    with(['getDataAmprahanPolri' => function($q) use ($cariWaktu){
                        $q->whereRaw('LENGTH(amprahan.nip) <= 8')
                        ->leftJoin('aturan_tunkin_detail',function($q){
                            $q->on('amprahan.kelas_jab_saat_amprah','=','aturan_tunkin_detail.kelas_jabatan'); // ini minta diganti juga
                            $q->on('aturan_tunkin_detail.id_aturan_tunkin','=','amprahan.kd_aturan');
                        })
                        ->orderBy('amprahan.kelas_jab_saat_amprah','DESC')
                        ->leftJoin('pegawai','amprahan.nip','=','pegawai.nip')
                        ->where('amprahan.status_dapat','1')
                        ->where('amprahan.state_tipikor_saat_amprah','1')
                        ->where('id_waktu',$cariWaktu->first()->id)
                        ->select(DB::raw('amprahan.*,tunjangan,pegawai.kawin,pegawai.tanggungan,pegawai.jenis_kelamin,pegawai.gapok,pegawai.tunj_strukfung,pegawai.tunj_lain'));
                    }])
                    // ->withCount(['getDataAmprahanPns' => function($q) use ($request){
                    //     $q->whereRaw('LENGTH(amprahan.nip) > 8')
                    //     ->where('amprahan.status_dapat','1');
                    // }])
                    ->with(['getDataAmprahanPns' => function($q) use ($cariWaktu){
                        $q->whereRaw('LENGTH(amprahan.nip) > 8')
                        ->leftJoin('aturan_tunkin_detail',function($q){
                            $q->on('amprahan.kelas_jab_saat_amprah','=','aturan_tunkin_detail.kelas_jabatan'); // ini minta diganti juga
                            $q->on('aturan_tunkin_detail.id_aturan_tunkin','=','amprahan.kd_aturan');
                        })
                        ->orderBy('amprahan.kelas_jab_saat_amprah','DESC')
                        ->leftJoin('pegawai','amprahan.nip','=','pegawai.nip')
                        ->where('amprahan.status_dapat','1')
                        ->where('amprahan.state_tipikor_saat_amprah','1')
                        ->where('id_waktu',$cariWaktu->first()->id)
                        ->select(DB::raw('amprahan.*,tunjangan,pegawai.kawin,pegawai.tanggungan,pegawai.jenis_kelamin,pegawai.gapok,pegawai.tunj_strukfung,pegawai.tunj_lain'));
                    }])

                    // ->with(['getDataAmprahanTipidkor' => function($q) use ($cariWaktu){
                    //     // $q->whereRaw('LENGTH(amprahan.nip) > 8')
                    //     $q->leftJoin('aturan_tunkin_detail',function($q){
                    //         $q->on('amprahan.kelas_jab_saat_amprah','=','aturan_tunkin_detail.kelas_jabatan'); // ini minta diganti juga
                    //         $q->on('aturan_tunkin_detail.id_aturan_tunkin','=','amprahan.kd_aturan');
                    //     })
                    //     ->orderBy('amprahan.kelas_jab_saat_amprah','DESC')
                    //     ->leftJoin('pegawai','amprahan.nip','=','pegawai.nip')
                    //     ->where('amprahan.status_dapat','1')
                    //     ->where('amprahan.state_tipikor_saat_amprah','1')
                    //     ->where('id_waktu',$cariWaktu->first()->id)
                    //     ->select(DB::raw('amprahan.*,tunjangan,pegawai.kawin,pegawai.tanggungan,pegawai.jenis_kelamin,pegawai.gapok,pegawai.tunj_strukfung,pegawai.tunj_lain'));
                    // }])
                    ->get();

                    foreach ($data as $key => $value) {  
                        // $value['listPolri'] = [16,15,14,13,12,11,10,9,8,7,6,5,4,3,2,1];
                        $value['getDataAmprahanPolriGroup'] = $value->getDataAmprahanPolri->groupBy('kelas_jab_saat_amprah');
                        foreach ($value['getDataAmprahanPolriGroup'] as $key2 => $val) {
                            foreach ($val as $key3 => $va) {
                                $va['pajak'] = intval(CH::formulaPPH($va->kawin,$va->tanggungan,$va->jenis_kelamin,$va->gapok,$va->tunj_strukfung,$va->tunjangan,$va->tunj_lain));
                            }
                            $val['jumlahOrang'] = $val->count();
                            $val['tunjangan'] = $val->sum('tunjangan') / $val['jumlahOrang'];
                            $val['jumlahPajak'] = $val->sum('pajak');
                            $val['jumlahTunjangan'] = $val->sum('tunjangan');
                        }
                        // $value['listPns'] = [16,15,14,13,12,11,10,9,8,7,6,5,4,3,2,1];
                        $value['getDataAmprahanPnsGroup'] = $value->getDataAmprahanPns->groupBy('kelas_jab_saat_amprah');
                        foreach ($value['getDataAmprahanPnsGroup'] as $key2 => $val) {
                            foreach ($val as $key3 => $va) {
                                $va['pajak'] = intval(CH::formulaPPH($va->kawin,$va->tanggungan,$va->jenis_kelamin,$va->gapok,$va->tunj_strukfung,$va->tunjangan,$va->tunj_lain));
                            }
                            $val['jumlahOrang'] = $val->count();
                            $val['tunjangan'] = $val->sum('tunjangan') / $val['jumlahOrang'];
                            $val['jumlahPajak'] = $val->sum('pajak');
                            $val['jumlahTunjangan'] = $val->sum('tunjangan');
                        }

                        //tipidkor
                        // $value['getDataAmprahanTipidkorGroup'] = $value->getDataAmprahanTipidkor->groupBy('kelas_jab_saat_amprah');
                        // foreach ($value['getDataAmprahanTipidkorGroup'] as $key2 => $val) {
                        //     foreach ($val as $key3 => $va) {
                        //         $va['pajak'] = intval(CH::formulaPPH($va->kawin,$va->tanggungan,$va->jenis_kelamin,$va->gapok,$va->tunj_strukfung,$va->tunjangan,$va->tunj_lain));
                        //     }
                        //     $val['jumlahOrang'] = $val->count();
                        //     $val['tunjangan'] = $val->sum('tunjangan') / $val['jumlahOrang'];
                        //     $val['jumlahPajak'] = $val->sum('pajak');
                        //     $val['jumlahTunjangan'] = $val->sum('tunjangan');
                        // }
                    }

                    // return Response::json($data[0]->getDataAmprahanPolriGroup,200,array(),JSON_PRETTY_PRINT);
            // foreach ($data as $key => $value) {              
            //     foreach ($value->getDataAmprahanPolri as $key2 => $val) {
            //         $val['pajak'] = CH::formulaPPH($val->kawin,$val->tanggungan,$val->jenis_kelamin,$val->gapok,$val->tunj_strukfung,$val->tunjangan,$val->tunj_lain);
            //     }
            //     foreach ($value->getDataAmprahanPns as $key2 => $val) {
            //         $val['pajak'] = CH::formulaPPH($val->kawin,$val->tanggungan,$val->jenis_kelamin,$val->gapok,$val->tunj_strukfung,$val->tunjangan,$val->tunj_lain);
            //     }               
            // }
            // foreach ($data as $key => $value) {
            //     echo $value->nm_satker."<br>";
            //     echo $value->getDataAmprahanPolri->sum('tunjangan')."<br><hr>";
            //     echo $value->getDataAmprahanPolri->count()."<br><hr>";
            //     foreach ($value->getDataAmprahanPolri as $key2 => $val) {
            //         echo $key2." ".$val->tunjangan.", pajak : ".$val->pajak."<br>";
            //     }
            // }
            // return Response::json($data, 200, array(), JSON_PRETTY_PRINT);
            return  ['status' => 'adadata','data' => $data,'bulan' => $listBulan[$bulan],'tahun' => $tahun];

        }
    }
}

