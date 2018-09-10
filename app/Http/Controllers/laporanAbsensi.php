<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\pegawai;
use CH;
use Yajra\Datatables\Datatables;
use App\aturan_absensi;
use App\waktu_absensi;
use App\absensi;
use App\aturan_tunkin;
use App\aturan_tunkin_detail;
use App\satker;
use App\TTD;
use DB;
class laporanAbsensi extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $mainPage = "laporanAbsensi";
    public $page = "Laporan Absensi Pegawai";
    public function laporanPerSatker()
    {
       
        
        
        //waktu absensi
        $data['tahunTerkecil'] = waktu_absensi::orderBy('tahun','ASC')->first()->tahun;        
        $data['dataAturanAbsensi'] = aturan_absensi::all();
        $data['page'] = $this->page;
        $data['subpage'] = "";    
        $data['aturan_absensi'] = aturan_absensi::orderBy('id','ASC')->get();
        $data['dataTTD'] = TTD::where(['halaman' => '1','kd_satker' => Auth::user()->kd_satker])->get();
        $data['dataSatker'] = [];
        if(Auth::user()->level == "admin")
            $data['dataSatker'] = satker::select('id','kd_satker','nm_satker')->get();

        return view($this->mainPage.".laporan1",$data);
    }
    public function laporan1()
    {
        //data
        /*
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
        */
        
        //waktu absensi
        $data['tahunTerkecil'] = waktu_absensi::orderBy('tahun','ASC')->first()->tahun;        
        $data['dataAturanAbsensi'] = aturan_absensi::all();
        $data['page'] = $this->page;
        $data['subpage'] = "";    
        $data['aturan_absensi'] = aturan_absensi::orderBy('id','ASC')->get();
        $data['dataTTD'] = TTD::where(['halaman' => '1','kd_satker' => Auth::user()->kd_satker])->get();
        $data['dataSatker'] = [];
        if(Auth::user()->level == "admin")
            $data['dataSatker'] = satker::select('id','kd_satker','nm_satker')->get();

        return view($this->mainPage.".laporan1",$data);
    }

    public function laporanB()
    {
        //data
        /*
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
        */
        
        //waktu absensi
        $data['tahunTerkecil'] = waktu_absensi::orderBy('tahun','ASC')->first()->tahun;        
        $data['dataAturanAbsensi'] = aturan_absensi::all();
        $data['page'] = $this->page;
        $data['subpage'] = "";    
        $data['aturan_absensi'] = aturan_absensi::orderBy('id','ASC')->get();
        $data['dataTTD'] = TTD::where(['halaman' => '2','kd_satker' => Auth::user()->kd_satker])->get();
        
        if($data['dataTTD']->count() == 0)
            return redirect('tandaTanganSetting/laporanB')->with(['status' => 'warning','message' => 'Anda Belum Mengisi Form Tanda Tangan']);

        $data['dataSatker'] = [];
        if(Auth::user()->level == "admin")
            $data['dataSatker'] = satker::select('id','kd_satker','nm_satker')->get();

        return view($this->mainPage.".laporanB",$data);
    }
    
    public function laporanSPP()
    {
        //data
        /*
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
        */
        
        //waktu absensi
        $data['tahunTerkecil'] = waktu_absensi::orderBy('tahun','ASC')->first()->tahun;        
        $data['dataAturanAbsensi'] = aturan_absensi::all();
        $data['page'] = $this->page;
        $data['subpage'] = "";    
        $data['aturan_absensi'] = aturan_absensi::orderBy('id','ASC')->get();
        $data['dataTTD'] = TTD::where(['halaman' => '3','kd_satker' => Auth::user()->kd_satker])->get();

        if($data['dataTTD']->count() == 0)
            return redirect('tandaTanganSetting/laporanSPP')->with(['status' => 'warning','message' => 'Anda Belum Mengisi Form Tanda Tangan']);        

        $data['dataSatker'] = [];
        if(Auth::user()->level == "admin")
            $data['dataSatker'] = satker::select('id','kd_satker','nm_satker')->get();

        return view($this->mainPage.".laporanSPP",$data);
    }
    public function laporanSPTJM()
    {
        //data
        /*
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
        */
        
        //waktu absensi
        $data['tahunTerkecil'] = waktu_absensi::orderBy('tahun','ASC')->first()->tahun;        
        $data['dataAturanAbsensi'] = aturan_absensi::all();
        $data['page'] = $this->page;
        $data['subpage'] = "";    
        $data['aturan_absensi'] = aturan_absensi::orderBy('id','ASC')->get();
        $data['dataTTD'] = TTD::where(['halaman' => '5','kd_satker' => Auth::user()->kd_satker])->get();

        if($data['dataTTD']->count() == 0)
            return redirect('tandaTanganSetting/laporanSPTJM')->with(['status' => 'warning','message' => 'Anda Belum Mengisi Form Tanda Tangan']);

        $data['dataSatker'] = [];
        if(Auth::user()->level == "admin")
            $data['dataSatker'] = satker::select('id','kd_satker','nm_satker')->get();

        return view($this->mainPage.".laporanSPTJM",$data);
    }

    public function laporanKU()
    {
        //data
        /*
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
        */
        
        //waktu absensi
        $data['tahunTerkecil'] = waktu_absensi::orderBy('tahun','ASC')->first()->tahun;        
        $data['dataAturanAbsensi'] = aturan_absensi::all();
        $data['page'] = $this->page;
        $data['subpage'] = "";    
        $data['aturan_absensi'] = aturan_absensi::orderBy('id','ASC')->get();
        $data['dataTTD'] = TTD::where(['halaman' => '4','kd_satker' => Auth::user()->kd_satker])->get();
        
        if($data['dataTTD']->count() == 0)
            return redirect('tandaTanganSetting/laporanKU')->with(['status' => 'warning','message' => 'Anda Belum Mengisi Form Tanda Tangan']);

        $data['dataSatker'] = [];
        if(Auth::user()->level == "admin")
            $data['dataSatker'] = satker::select('id','kd_satker','nm_satker')->get();

        return view($this->mainPage.".laporanKU",$data);
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
    public function pilihBulanTahunB(Request $request)
    {
        //cari data yang sesuai
        $bulan = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        $where = ['bulan' => $request->bulan, 'tahun' => $request->tahun];
        $query = waktu_absensi::where($where)->get();
        $formula = aturan_absensi::orderBy('id','ASC')->get();
        if($query->count() == 0)
        {
            //buat data jika tidak ada            
            return ['status' => 'nodata','dataAbsensi' => null];
        }
        else if($query->count() == 1)
        {
        	$id_aturan_tunkin = aturan_tunkin::where('state','1')->first()->id;
        	if(Auth::user()->level == "admin")
            {
                $q2 = pegawai::leftJoin('absensi','pegawai.nip','=','absensi.nip')
                    ->leftJoin('pangkat','pegawai.kd_pangkat','=','pangkat.kd_pangkat')
                    ->leftJoin('jabatan','pegawai.kd_jab','=','jabatan.kd_jabatan')
                    ->leftJoin('satker','pegawai.kd_satker','=','satker.kd_satker')
                    ->leftJoin('aturan_tunkin_detail',function($q){
                        $q->on('pegawai.kelas_jab','=','aturan_tunkin_detail.kelas_jabatan');
                        $q->on('aturan_tunkin_detail.id_aturan_tunkin',"absensi.kd_aturan");
                    })
                    ->where('absensi.id_waktu',$query[0]['id']);
                    
            }
            else
            {
                $q2 = pegawai::leftJoin('absensi','pegawai.nip','=','absensi.nip')
                    ->leftJoin('pangkat','pegawai.kd_pangkat','=','pangkat.kd_pangkat')
                    ->leftJoin('jabatan','pegawai.kd_jab','=','jabatan.kd_jabatan')
                    ->leftJoin('satker','pegawai.kd_satker','=','satker.kd_satker')
                    ->leftJoin('aturan_tunkin_detail',function($q){
                        $q->on('pegawai.kelas_jab','=','aturan_tunkin_detail.kelas_jabatan');
                        $q->on('aturan_tunkin_detail.id_aturan_tunkin',"absensi.kd_aturan");
                    })
                    ->where('absensi.kd_satker_saat_absensi',CH::getKdSatker(Auth::user()->kd_satker))
                    ->where('absensi.id_waktu',$query[0]['id']);
            }

            $q2 //->groupBy('pegawai.kelas_jab')
                    ->orderBy('pegawai.kelas_jab','DESC')   
                    ->orderBy('pegawai.kd_satker','ASC')
                    ->selectRaw(DB::raw('pegawai.* ,  aturan_tunkin_detail.tunjangan')); 
            //cek apakah ada request berdasarkan satker
            if($request->satker != "")
                $q2->where('pegawai.kd_satker',$request->satker);
            //cek apakah di requect polri atau pns
            $keanggotaan = "POLRI & PNS";
            if($request->jenis_pegawai == "0")
            {
                $q2->whereRaw('LENGTH(pegawai.nip) <= 8'); // polri
                $keanggotaan = "POLRI";
            }
            else if($request->jenis_pegawai == "1")
            {
                $q2->whereRaw('LENGTH(pegawai.nip) > 8'); // pns
                $keanggotaan = "PNS";
            }

            //cari aturan tunkin detail
            $tunkin = aturan_tunkin_detail::leftJoin('aturan_tunkin','aturan_tunkin_detail.id_aturan_tunkin','=','aturan_tunkin.id')->where('state','1')->orderBy('kelas_jabatan','DESC')->get();       

            /*
            $nilaiBalik = [];     
            foreach ($tunkin as $key => $value) {
                $state = false;
                foreach ($q2->get() as $key => $val) {
                    if($val->kelas_jab == $value->kelas_jabatan)
                    {
                        array_push($nilaiBalik, $val);
                        $state = true;
                        break;
                    }
                }
                if($state == false)
                {
                    array_push($nilaiBalik, ['kelas_jab' => $value->kelas_jabatan , 'tunjangan' => $value->tunjangan , 'countKelasJab' => 0]);                    
                }
            }
            */
            $nilaiBalik = [];
            foreach ($q2->get() as $key => $val) {
                
                if (array_key_exists($val->kelas_jab, $nilaiBalik)) {
                    $nilaiBalik[$val->kelas_jab]['kelas_jab'] = $val->kelas_jab;
                    $nilaiBalik[$val->kelas_jab]['count_orang'] +=1;
                    $nilaiBalik[$val->kelas_jab]['tunjangan'] = $val->tunjangan;
                    $nilaiBalik[$val->kelas_jab]['pph'] += intval(CH::formulaPPH($val->kawin,$val->tanggungan,$val->jenis_kelamin,$val->gapok,$val->tunj_strukfung,$val->tunjangan,$val->tunj_lain));
                }
                else
                {
                    $nilaiBalik[$val->kelas_jab]['kelas_jab'] = $val->kelas_jab;
                    $nilaiBalik[$val->kelas_jab]['count_orang'] = 1;
                    $nilaiBalik[$val->kelas_jab]['tunjangan'] = $val->tunjangan;
                    $nilaiBalik[$val->kelas_jab]['pph'] = intval(CH::formulaPPH($val->kawin,$val->tanggungan,$val->jenis_kelamin,$val->gapok,$val->tunj_strukfung,$val->tunjangan,$val->tunj_lain));

                }
            }

            $returnVal = [];     
            foreach ($tunkin as $key => $value) {
                $state = false;
                foreach ($nilaiBalik as $key => $val) {
                    if($val['kelas_jab'] == $value->kelas_jabatan)
                    {
                        array_push($returnVal, $val);
                        $state = true;
                        break;
                    }
                }
                if($state == false)
                {
                    array_push($returnVal, ['kelas_jab' => $value->kelas_jabatan , 'tunjangan' => $value->tunjangan , 'count_orang' => 0 ,'pph' => '0']);                    
                }
            }


            return ['idBulanTahun' => $query[0]['id'],'status' => 'success','dataAbsensi' => $returnVal,'formula' => $formula,'tunkin' => $tunkin, 'bulan' => $bulan[$request->bulan] ,'tahun' => $request->tahun,'keanggotaan' => $keanggotaan];            
        }
        else
        {
            return ['status' => 'failed'];
        }
    }

    public function pilihBulanTahunSPP(Request $request)
    {
        //cari data yang sesuai       
        $bulan = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        //cari data yang sesuai
        $where = ['bulan' => $request->bulan, 'tahun' => $request->tahun];
        $query = waktu_absensi::where($where)->get();
        $formula = aturan_absensi::orderBy('id','ASC')->get();
        if($query->count() == 0)
        {
            //buat data jika tidak ada            
            return ['status' => 'nodata','dataAbsensi' => null];
        }
        else if($query->count() == 1)
        {
            $id_aturan_tunkin = aturan_tunkin::where('state','1')->first()->id;
            if(Auth::user()->level == "admin")
            {
                $q2 = pegawai::leftJoin('absensi','pegawai.nip','=','absensi.nip')
                    ->leftJoin('pangkat','pegawai.kd_pangkat','=','pangkat.kd_pangkat')
                    ->leftJoin('jabatan','pegawai.kd_jab','=','jabatan.kd_jabatan')
                    ->leftJoin('satker','pegawai.kd_satker','=','satker.kd_satker')
                    ->leftJoin('aturan_tunkin_detail',function($q){
                        $q->on('pegawai.kelas_jab','=','aturan_tunkin_detail.kelas_jabatan');
                        $q->on('aturan_tunkin_detail.id_aturan_tunkin',"absensi.kd_aturan");
                    })
                    ->where('absensi.id_waktu',$query[0]['id']);
                    
            }
            else
            {
                $q2 = pegawai::leftJoin('absensi','pegawai.nip','=','absensi.nip')
                    ->leftJoin('pangkat','pegawai.kd_pangkat','=','pangkat.kd_pangkat')
                    ->leftJoin('jabatan','pegawai.kd_jab','=','jabatan.kd_jabatan')
                    ->leftJoin('satker','pegawai.kd_satker','=','satker.kd_satker')
                    ->leftJoin('aturan_tunkin_detail',function($q){
                        $q->on('pegawai.kelas_jab','=','aturan_tunkin_detail.kelas_jabatan');
                        $q->on('aturan_tunkin_detail.id_aturan_tunkin',"absensi.kd_aturan");
                    })
                    ->where('absensi.kd_satker_saat_absensi',CH::getKdSatker(Auth::user()->kd_satker))
                    ->where('absensi.id_waktu',$query[0]['id']);
            }

            $q2 //->groupBy('pegawai.kelas_jab')
                    ->orderBy('pegawai.kelas_jab','DESC')   
                    ->orderBy('pegawai.kd_satker','ASC')
                    ->selectRaw(DB::raw('pegawai.* ,  aturan_tunkin_detail.tunjangan')); 
            //cek apakah ada request berdasarkan satker
            if($request->satker != "")
                $q2->where('pegawai.kd_satker',$request->satker);
            //cek apakah di requect polri atau pns
            if($request->jenis_pegawai == "0")
                $q2->whereRaw('LENGTH(pegawai.nip) <= 8'); // polri
            else if($request->jenis_pegawai == "1")
                $q2->whereRaw('LENGTH(pegawai.nip) > 8'); // pns

            //cari aturan tunkin detail
            $tunkin = aturan_tunkin_detail::leftJoin('aturan_tunkin','aturan_tunkin_detail.id_aturan_tunkin','=','aturan_tunkin.id')->where('state','1')->orderBy('kelas_jabatan','DESC')->get();       

            /*
            $nilaiBalik = [];     
            foreach ($tunkin as $key => $value) {
                $state = false;
                foreach ($q2->get() as $key => $val) {
                    if($val->kelas_jab == $value->kelas_jabatan)
                    {
                        array_push($nilaiBalik, $val);
                        $state = true;
                        break;
                    }
                }
                if($state == false)
                {
                    array_push($nilaiBalik, ['kelas_jab' => $value->kelas_jabatan , 'tunjangan' => $value->tunjangan , 'countKelasJab' => 0]);                    
                }
            }
            */
            $nilaiBalik = [];
            foreach ($q2->get() as $key => $val) {
                
                if (array_key_exists($val->kelas_jab, $nilaiBalik)) {
                    $nilaiBalik[$val->kelas_jab]['kelas_jab'] = $val->kelas_jab;
                    $nilaiBalik[$val->kelas_jab]['count_orang'] +=1;
                    $nilaiBalik[$val->kelas_jab]['tunjangan'] = $val->tunjangan;
                    $nilaiBalik[$val->kelas_jab]['pph'] += intval(CH::formulaPPH($val->kawin,$val->tanggungan,$val->jenis_kelamin,$val->gapok,$val->tunj_strukfung,$val->tunjangan,$val->tunj_lain));
                }
                else
                {
                    $nilaiBalik[$val->kelas_jab]['kelas_jab'] = $val->kelas_jab;
                    $nilaiBalik[$val->kelas_jab]['count_orang'] = 1;
                    $nilaiBalik[$val->kelas_jab]['tunjangan'] = $val->tunjangan;
                    $nilaiBalik[$val->kelas_jab]['pph'] = intval(CH::formulaPPH($val->kawin,$val->tanggungan,$val->jenis_kelamin,$val->gapok,$val->tunj_strukfung,$val->tunjangan,$val->tunj_lain));
                }
            }

            $returnVal = [];     
            foreach ($tunkin as $key => $value) {
                $state = false;
                foreach ($nilaiBalik as $key => $val) {
                    if($val['kelas_jab'] == $value->kelas_jabatan)
                    {
                        array_push($returnVal, $val);
                        $state = true;
                        break;
                    }
                }
                if($state == false)
                {
                    array_push($returnVal, ['kelas_jab' => $value->kelas_jabatan , 'tunjangan' => $value->tunjangan , 'count_orang' => 0 ,'pph' => '0']);                    
                }
            }
            // //satker            
            ///
            //$mengenaiWord = "Pembayaran Tunjangan Kinerja";

            //jenis pegawai            
            if($request->jenis_pegawai == "0")
                $anggota=" Anggota Polri";                
            else if($request->jenis_pegawai == "1")
                $anggota=" PNS Polri";    
            else
                $anggota=" Polri & PNS";            

            //satker            
            $satkerNama = "";
            if($request->satker != "")
            {
                $satker = satker::where('kd_satker',$request->satker)->first()->nm_satker;            
                $satkerNama=" Satker ".$satker;
            }

            $mengenaiWord=" bulan ".$bulan[$request->bulan]." ".$request->tahun;

            return ['idBulanTahun' => $query[0]['id'],'status' => 'success','dataAbsensi' => $returnVal,'formula' => $formula,'tunkin' => $tunkin,'words' => $mengenaiWord,'anggota' => $anggota,'satkerNama'=>$satkerNama];            
        }
        else
        {
            return ['status' => 'failed'];
        }
    }

    public function pilihBulanTahunKU(Request $request)
    {
        $bulan = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        //cari data yang sesuai
        $where = ['bulan' => $request->bulan, 'tahun' => $request->tahun];
        $query = waktu_absensi::where($where)->get();
        $formula = aturan_absensi::orderBy('id','ASC')->get();
        if($query->count() == 0)
        {
            //buat data jika tidak ada            
            return ['status' => 'nodata','dataAbsensi' => null];
        }
        else if($query->count() == 1)
        {
            $id_aturan_tunkin = aturan_tunkin::where('state','1')->first()->id;
            if(Auth::user()->level == "admin")
            {
                $q2 = pegawai::leftJoin('absensi','pegawai.nip','=','absensi.nip')
                    ->leftJoin('pangkat','pegawai.kd_pangkat','=','pangkat.kd_pangkat')
                    ->leftJoin('jabatan','pegawai.kd_jab','=','jabatan.kd_jabatan')
                    ->leftJoin('satker','pegawai.kd_satker','=','satker.kd_satker')
                    ->leftJoin('aturan_tunkin_detail',function($q){
                        $q->on('pegawai.kelas_jab','=','aturan_tunkin_detail.kelas_jabatan');
                        $q->on('aturan_tunkin_detail.id_aturan_tunkin',"absensi.kd_aturan");
                    })
                    ->where('absensi.id_waktu',$query[0]['id']);
                    
            }
            else
            {
                $q2 = pegawai::leftJoin('absensi','pegawai.nip','=','absensi.nip')
                    ->leftJoin('pangkat','pegawai.kd_pangkat','=','pangkat.kd_pangkat')
                    ->leftJoin('jabatan','pegawai.kd_jab','=','jabatan.kd_jabatan')
                    ->leftJoin('satker','pegawai.kd_satker','=','satker.kd_satker')
                    ->leftJoin('aturan_tunkin_detail',function($q){
                        $q->on('pegawai.kelas_jab','=','aturan_tunkin_detail.kelas_jabatan');
                        $q->on('aturan_tunkin_detail.id_aturan_tunkin',"absensi.kd_aturan");
                    })
                    ->where('absensi.kd_satker_saat_absensi',CH::getKdSatker(Auth::user()->kd_satker))
                    ->where('absensi.id_waktu',$query[0]['id']);
            }

            $q2 //->groupBy('pegawai.kelas_jab')
                    ->orderBy('pegawai.kelas_jab','DESC')   
                    ->orderBy('pegawai.kd_satker','ASC')
                    ->selectRaw(DB::raw('pegawai.* ,  aturan_tunkin_detail.tunjangan')); 
            //cek apakah ada request berdasarkan satker
            if($request->satker != "")
                $q2->where('pegawai.kd_satker',$request->satker);
            //cek apakah di requect polri atau pns
            if($request->jenis_pegawai == "0")
                $q2->whereRaw('LENGTH(pegawai.nip) <= 8'); // polri
            else if($request->jenis_pegawai == "1")
                $q2->whereRaw('LENGTH(pegawai.nip) > 8'); // pns

            //cari aturan tunkin detail
            $tunkin = aturan_tunkin_detail::leftJoin('aturan_tunkin','aturan_tunkin_detail.id_aturan_tunkin','=','aturan_tunkin.id')->where('state','1')->orderBy('kelas_jabatan','DESC')->get();       

            /*
            $nilaiBalik = [];     
            foreach ($tunkin as $key => $value) {
                $state = false;
                foreach ($q2->get() as $key => $val) {
                    if($val->kelas_jab == $value->kelas_jabatan)
                    {
                        array_push($nilaiBalik, $val);
                        $state = true;
                        break;
                    }
                }
                if($state == false)
                {
                    array_push($nilaiBalik, ['kelas_jab' => $value->kelas_jabatan , 'tunjangan' => $value->tunjangan , 'countKelasJab' => 0]);                    
                }
            }
            */
            $nilaiBalik = [];
            foreach ($q2->get() as $key => $val) {
                
                if (array_key_exists($val->kelas_jab, $nilaiBalik)) {
                    $nilaiBalik[$val->kelas_jab]['kelas_jab'] = $val->kelas_jab;
                    $nilaiBalik[$val->kelas_jab]['count_orang'] +=1;
                    $nilaiBalik[$val->kelas_jab]['tunjangan'] = $val->tunjangan;
                    $nilaiBalik[$val->kelas_jab]['pph'] += intval(CH::formulaPPH($val->kawin,$val->tanggungan,$val->jenis_kelamin,$val->gapok,$val->tunj_strukfung,$val->tunjangan,$val->tunj_lain));
                }
                else
                {
                    $nilaiBalik[$val->kelas_jab]['kelas_jab'] = $val->kelas_jab;
                    $nilaiBalik[$val->kelas_jab]['count_orang'] = 1;
                    $nilaiBalik[$val->kelas_jab]['tunjangan'] = $val->tunjangan;
                    $nilaiBalik[$val->kelas_jab]['pph'] = intval(CH::formulaPPH($val->kawin,$val->tanggungan,$val->jenis_kelamin,$val->gapok,$val->tunj_strukfung,$val->tunjangan,$val->tunj_lain));
                }
            }

            $returnVal = [];     
            foreach ($tunkin as $key => $value) {
                $state = false;
                foreach ($nilaiBalik as $key => $val) {
                    if($val['kelas_jab'] == $value->kelas_jabatan)
                    {
                        array_push($returnVal, $val);
                        $state = true;
                        break;
                    }
                }
                if($state == false)
                {
                    array_push($returnVal, ['kelas_jab' => $value->kelas_jabatan , 'tunjangan' => $value->tunjangan , 'count_orang' => 0 ,'pph' => '0']);                    
                }
            }
            //
            //$mengenaiWord = "Pembayaran Tunjangan Kinerja";

            //jenis pegawai            
            if($request->jenis_pegawai == "0")
                $anggota=" Anggota Polri";                
            else if($request->jenis_pegawai == "1")
                $anggota=" PNS Polri";    
            else
                $anggota=" Polri & PNS";            

            //satker            
            $satkerNama = "";
            if($request->satker != "")
            {
                $satker = satker::where('kd_satker',$request->satker)->first()->nm_satker;            
                $satkerNama=" Satker ".$satker;
            }

            $mengenaiWord=" bulan ".$bulan[$request->bulan]." ".$request->tahun;

            return ['idBulanTahun' => $query[0]['id'],'status' => 'success','dataAbsensi' => $nilaiBalik,'formula' => $formula,'tunkin' => $tunkin,'words' => $mengenaiWord,'anggota'=>$anggota,'satkerNama' => $satkerNama];            
        }
        else
        {
            return ['status' => 'failed'];
        }
    }


    public function pilihBulanTahun(Request $request)
    {
        //cari data yang sesuai
        $bulan = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        $where = ['bulan' => $request->bulan, 'tahun' => $request->tahun];
        $query = waktu_absensi::where($where)->get();
        $formula = aturan_absensi::orderBy('id','ASC')->get();
        if($query->count() == 0)
        {
            //buat data jika tidak ada            
            return ['status' => 'nodata','dataAbsensi' => null];
        }
        else if($query->count() == 1)
        {
            $id_aturan_tunkin = aturan_tunkin::where('state','1')->first()->id;
            if(Auth::user()->level == "admin")
            {
                $q2 = pegawai::leftJoin('absensi','pegawai.nip','=','absensi.nip')
                    ->leftJoin('pangkat','pegawai.kd_pangkat','=','pangkat.kd_pangkat')
                    ->leftJoin('jabatan','pegawai.kd_jab','=','jabatan.kd_jabatan')
                    ->leftJoin('satker','pegawai.kd_satker','=','satker.kd_satker')
                    ->leftJoin('aturan_tunkin_detail',function($q){
                        $q->on('pegawai.kelas_jab','=','aturan_tunkin_detail.kelas_jabatan');
                        $q->on('aturan_tunkin_detail.id_aturan_tunkin',"absensi.kd_aturan");
                    })
                    ->where('absensi.id_waktu',$query[0]['id'])
                    ->orderBy('pegawai.kd_satker','ASC')
                    ->orderBy('pegawai.kelas_jab','DESC');
            }
            else
            {
                $q2 = pegawai::leftJoin('absensi','pegawai.nip','=','absensi.nip')
                    ->leftJoin('pangkat','pegawai.kd_pangkat','=','pangkat.kd_pangkat')
                    ->leftJoin('jabatan','pegawai.kd_jab','=','jabatan.kd_jabatan')
                    ->leftJoin('satker','pegawai.kd_satker','=','satker.kd_satker')
                    ->leftJoin('aturan_tunkin_detail',function($q){
                        $q->on('pegawai.kelas_jab','=','aturan_tunkin_detail.kelas_jabatan');
                        $q->on('aturan_tunkin_detail.id_aturan_tunkin',"absensi.kd_aturan");
                    })
                    ->where('absensi.kd_satker_saat_absensi',CH::getKdSatker(Auth::user()->kd_satker))
                    ->where('absensi.id_waktu',$query[0]['id'])
                    ->orderBy('pegawai.kd_satker','ASC')
                    ->orderBy('pegawai.kelas_jab','DESC');   
            }
            //cek apakah ada request berdasarkan satker
            if($request->satker != "")
                $q2->where('pegawai.kd_satker',$request->satker);
            //cek apakah di requect polri atau pns
            if($request->jenis_pegawai == "0")
            {
                $q2->whereRaw('LENGTH(pegawai.nip) <= 8'); // polri
                $keanggotaan = "POLRI";
            }
            else if($request->jenis_pegawai == "1")
            {
                $q2->whereRaw('LENGTH(pegawai.nip) > 8'); // pns
                $keanggotaan = "PNS";
            }
            else
            {
                $keanggotaan = "POLRI & PNS";
            }

            $dataSend = [];            
            foreach ($q2->get() as $key => $value) {
                $dataSend[$key] = $value;
                $dataSend[$key]['pajak'] = CH::formulaPPH($value->kawin,$value->tanggungan,$value->jenis_kelamin,$value->gapok,$value->tunj_strukfung,$value->tunjangan,$value->tunj_lain);
            }
            return ['idBulanTahun' => $query[0]['id'],'status' => 'success','dataAbsensi' => $dataSend,'formula' => $formula , 'bulan' => $bulan[$request->bulan] ,'tahun' => $request->tahun ,'keanggotaan' => $keanggotaan];            
        }
        else
        {
            return ['status' => 'failed'];
        }
    }
    public function cekLap()
    {
        $q2 = pegawai::leftJoin('absensi','pegawai.nip','=','absensi.nip')
                    ->leftJoin('pangkat','pegawai.kd_pangkat','=','pangkat.kd_pangkat')
                    ->leftJoin('jabatan','pegawai.kd_jab','=','jabatan.kd_jabatan')
                    ->leftJoin('aturan_tunkin_detail',function($q){
                        $q->on('pegawai.kelas_jab','=','aturan_tunkin_detail.kelas_jabatan');
                        $q->on('aturan_tunkin_detail.id_aturan_tunkin',"absensi.kd_aturan");
                    })
                    
                    
                    ->where('pegawai.kd_satker',"S1")
                    ->where('absensi.id_waktu',"1")->get(); 
        return $q2;
    }
}
