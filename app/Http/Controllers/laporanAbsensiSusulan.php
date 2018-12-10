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
use App\anak_satker;
use App\TTD;
use DB;
use App\absensiSusulan;
class laporanAbsensiSusulan extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $mainPage = "laporanAbsensiSusulan";
    public $page = "Laporan Absensi Susulan Pegawai";

    public function laporanPerSatkerSusulan()
    {
        
        //waktu absensi
        $data['tahunTerkecil'] = waktu_absensi::orderBy('tahun','ASC')->first()->tahun;        
        $data['dataAturanAbsensi'] = aturan_absensi::all();
        $data['page'] = "Laporan Rekap Tunkin Susulan";
        $data['subpage'] = "";    
        $data['aturan_absensi'] = aturan_absensi::orderBy('id','ASC')->get();
        $data['dataTTD'] = TTD::where(['halaman' => '1','kd_satker' => Auth::user()->kd_satker])->get();
        $data['dataSatker'] = [];
        if(Auth::user()->level == "admin")
            $data['dataSatker'] = satker::select('id','kd_satker','nm_satker')->get();

        return view($this->mainPage.".laporanPerSatker",$data);
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
        $data['page'] = "DAFTAR PEMBAYARAN TUNJANGAN KINERJA SUSULAN";
        $data['subpage'] = "";    
        $data['aturan_absensi'] = aturan_absensi::orderBy('id','ASC')->get();
        $data['dataTTD'] = TTD::where(['halaman' => '1','kd_satker' => Auth::user()->kd_satker])->get();
        if(Auth::user()->level == "operator")
            {
                if($data['dataTTD']->count() == 0)
                    return redirect('tandaTanganSetting/laporan1')->with(['status' => 'warning','message' => 'Anda Belum Mengisi Form Tanda Tangan']);
            }
        $data['dataSatker'] = [];
        if(Auth::user()->level == "admin")
            $data['dataSatker'] = satker::select('id','kd_satker','nm_satker')->get();

        if(Auth::user()->level == "admin")
            $data['dataAnakSatker'] = anak_satker::all();
        else
            $data['dataAnakSatker'] = anak_satker::where('kd_satker',CH::getKdSatker(Auth::user()->kd_satker))->get();

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
        $data['page'] = "REKAPITULASI DAFTAR PEMBAYARAN TUNJANGAN KINERJA SUSULAN";
        $data['subpage'] = "";    
        $data['aturan_absensi'] = aturan_absensi::orderBy('id','ASC')->get();
        $data['dataTTD'] = TTD::where(['halaman' => '2','kd_satker' => Auth::user()->kd_satker])->get();
        
        if(Auth::user()->level == "operator")
            {
                if($data['dataTTD']->count() == 0)
                    return redirect('tandaTanganSetting/laporanB')->with(['status' => 'warning','message' => 'Anda Belum Mengisi Form Tanda Tangan']);
            }

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

        if(Auth::user()->level == "operator")
            {
                if($data['dataTTD']->count() == 0)
                    return redirect('tandaTanganSetting/laporanSPP')->with(['status' => 'warning','message' => 'Anda Belum Mengisi Form Tanda Tangan']);
            }      

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

        if(Auth::user()->level == "operator")
            {
                if($data['dataTTD']->count() == 0)
                    return redirect('tandaTanganSetting/laporanSPTJM')->with(['status' => 'warning','message' => 'Anda Belum Mengisi Form Tanda Tangan']);
            }

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
        
        if(Auth::user()->level == "operator")
            {
                if($data['dataTTD']->count() == 0)
                    return redirect('tandaTanganSetting/laporanKU')->with(['status' => 'warning','message' => 'Anda Belum Mengisi Form Tanda Tangan']);
            }

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
        $bulan = CH::listBulan();
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
                $q2 = pegawai::leftJoin('absensi_susulan','pegawai.nip','=','absensi_susulan.nip')
                    ->leftJoin('pangkat','pegawai.kd_pangkat','=','pangkat.kd_pangkat')
                    ->leftJoin('jabatan','pegawai.kd_jab','=','jabatan.kd_jabatan')
                    ->leftJoin('satker','absensi_susulan.kd_satker_saat_absensi','=','satker.kd_satker')
                   ->leftJoin('aturan_tunkin_detail',function($q){
                        $q->on('absensi_susulan.kelas_jab_saat_absensi','=','aturan_tunkin_detail.kelas_jabatan'); // ini minta diganti juga
                        $q->on('aturan_tunkin_detail.id_aturan_tunkin','=','absensi_susulan.kd_aturan');
                    })
                    ->where('absensi_susulan.id_waktu',$query[0]['id']);

                    //hps
                   
                    
            }
            else
            {
                $q2 = pegawai::leftJoin('absensi_susulan','pegawai.nip','=','absensi_susulan.nip')
                    ->leftJoin('pangkat','pegawai.kd_pangkat','=','pangkat.kd_pangkat')
                    ->leftJoin('jabatan','pegawai.kd_jab','=','jabatan.kd_jabatan')
                     ->leftJoin('satker','absensi_susulan.kd_satker_saat_absensi','=','satker.kd_satker')
                   ->leftJoin('aturan_tunkin_detail',function($q){
                        $q->on('absensi_susulan.kelas_jab_saat_absensi','=','aturan_tunkin_detail.kelas_jabatan'); // ini minta diganti juga
                        $q->on('aturan_tunkin_detail.id_aturan_tunkin','=','absensi_susulan.kd_aturan');
                    })
                    ->where('absensi_susulan.kd_satker_saat_absensi',CH::getKdSatker(Auth::user()->kd_satker))
                    ->where('absensi_susulan.id_waktu',$query[0]['id']);
            }

            $q2 //->groupBy('pegawai.kelas_jab')
                    ->orderBy('absensi_susulan.kd_satker_saat_absensi','ASC')
                    ->orderBy('absensi_susulan.kd_anak_satker_saat_absensi','ASC')
                    ->orderBy('absensi_susulan.kelas_jab_saat_absensi','DESC')
                    ->selectRaw(DB::raw('pegawai.* ,  aturan_tunkin_detail.tunjangan , absensi_susulan.*')); 
            //cek apakah ada request berdasarkan satker
            if($request->satker != "")
                $q2->where('absensi_susulan.kd_satker_saat_absensi',$request->satker);
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
                
                if (array_key_exists($val->kelas_jab_saat_absensi, $nilaiBalik)) {
                    $nilaiBalik[$val->kelas_jab_saat_absensi]['kelas_jab'] = $val->kelas_jab_saat_absensi;
                    $nilaiBalik[$val->kelas_jab_saat_absensi]['count_orang'] +=1;
                    

                    $nilaiBalik[$val->kelas_jab_saat_absensi]['absensiValue1'] = CH::absensiFormulaMath($formula[0]['rumus'],$val->tunjangan,$val->absensi1);
                    $nilaiBalik[$val->kelas_jab_saat_absensi]['absensiValue2'] = CH::absensiFormulaMath($formula[1]['rumus'],$val->tunjangan,$val->absensi2);
                    $nilaiBalik[$val->kelas_jab_saat_absensi]['absensiValue3'] = CH::absensiFormulaMath($formula[2]['rumus'],$val->tunjangan,$val->absensi3);
                    $nilaiBalik[$val->kelas_jab_saat_absensi]['absensiValue4'] = CH::absensiFormulaMath($formula[3]['rumus'],$val->tunjangan,$val->absensi4);
                    $jumlahPengurangan = intval($nilaiBalik[$val->kelas_jab_saat_absensi]['absensiValue1']+$nilaiBalik[$val->kelas_jab_saat_absensi]['absensiValue2']+$nilaiBalik[$val->kelas_jab_saat_absensi]['absensiValue3']+$nilaiBalik[$val->kelas_jab_saat_absensi]['absensiValue4']);
                    $nilaiBalik[$val->kelas_jab_saat_absensi]['jumlahPengurangan'] += $jumlahPengurangan;
                    

                    $jadiTunjangan = $val->tunjangan-$jumlahPengurangan;
                    $nilaiBalik[$val->kelas_jab_saat_absensi]['indexTunjangan']= $val->tunjangan;
                    $nilaiBalik[$val->kelas_jab_saat_absensi]['tunjangan']+= $val->tunjangan;
                    $nilaiBalik[$val->kelas_jab_saat_absensi]['tunjanganNetto']+= $jadiTunjangan;
                    $nilaiBalik[$val->kelas_jab_saat_absensi]['pph'] += CH::formulaPPH($val->nip,$val->kawin,$val->tanggungan,$val->jenis_kelamin,$val->gapok,$val->tunj_strukfung,$val->tunjangan,$val->tunj_lain);
                    $nilaiBalik[$val->kelas_jab_saat_absensi]['pphNetto'] += CH::formulaPPH($val->nip,$val->kawin,$val->tanggungan,$val->jenis_kelamin,$val->gapok,$val->tunj_strukfung,$jadiTunjangan,$val->tunj_lain);
                }
                else
                {
                    $nilaiBalik[$val->kelas_jab_saat_absensi]['kelas_jab'] = $val->kelas_jab_saat_absensi;
                    $nilaiBalik[$val->kelas_jab_saat_absensi]['count_orang'] = 1;
                    $nilaiBalik[$val->kelas_jab_saat_absensi]['absensiValue1'] = CH::absensiFormulaMath($formula[0]['rumus'],$val->tunjangan,$val->absensi1);
                    $nilaiBalik[$val->kelas_jab_saat_absensi]['absensiValue2'] = CH::absensiFormulaMath($formula[1]['rumus'],$val->tunjangan,$val->absensi2);
                    $nilaiBalik[$val->kelas_jab_saat_absensi]['absensiValue3'] = CH::absensiFormulaMath($formula[2]['rumus'],$val->tunjangan,$val->absensi3);
                    $nilaiBalik[$val->kelas_jab_saat_absensi]['absensiValue4'] = CH::absensiFormulaMath($formula[3]['rumus'],$val->tunjangan,$val->absensi4);
                    $jumlahPengurangan = intval($nilaiBalik[$val->kelas_jab_saat_absensi]['absensiValue1']+$nilaiBalik[$val->kelas_jab_saat_absensi]['absensiValue2']+$nilaiBalik[$val->kelas_jab_saat_absensi]['absensiValue3']+$nilaiBalik[$val->kelas_jab_saat_absensi]['absensiValue4']);
                    $nilaiBalik[$val->kelas_jab_saat_absensi]['jumlahPengurangan'] = $jumlahPengurangan;
                    
                    $jadiTunjangan = $val->tunjangan-$jumlahPengurangan;
                    $nilaiBalik[$val->kelas_jab_saat_absensi]['indexTunjangan']= $val->tunjangan;
                    $nilaiBalik[$val->kelas_jab_saat_absensi]['tunjangan']= $val->tunjangan;
                    $nilaiBalik[$val->kelas_jab_saat_absensi]['tunjanganNetto']= $jadiTunjangan;
                    $nilaiBalik[$val->kelas_jab_saat_absensi]['pph'] = CH::formulaPPH($val->nip,$val->kawin,$val->tanggungan,$val->jenis_kelamin,$val->gapok,$val->tunj_strukfung,$val->tunjangan,$val->tunj_lain);
                    $nilaiBalik[$val->kelas_jab_saat_absensi]['pphNetto'] = CH::formulaPPH($val->nip,$val->kawin,$val->tanggungan,$val->jenis_kelamin,$val->gapok,$val->tunj_strukfung,$jadiTunjangan,$val->tunj_lain);

                }
            }
            // return $nilaiBalik;
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
                     array_push($returnVal, ['jumlahPengurangan'=> 0 ,'kelas_jab' => $value->kelas_jabatan , 'indexTunjangan' => $value->tunjangan , 'count_orang' => 0 ,'pph' => '0']);                      
                }
            }

            //
            if(Auth::user()->level == "operator")
                $selectedSatker = satker::where('kd_satker',CH::getKdSatker(Auth::user()->kd_satker))->first();
            else if($request->satker != "")
                $selectedSatker = satker::where('kd_satker',$request->satker)->first();
            else
                $selectedSatker['nm_satker'] = "";
            //
            return ['idBulanTahun' => $query[0]['id'],'status' => 'success','dataAbsensi' => $returnVal,'formula' => $formula,'tunkin' => $tunkin, 'bulan' => $bulan[$request->bulan] ,'tahun' => $request->tahun,'keanggotaan' => $keanggotaan,'selectedSatker' => $selectedSatker];            
        }
        else
        {
            return ['status' => 'failed'];
        }
    }

    public function pilihBulanTahunSPP(Request $request)
    {
        //cari data yang sesuai       
        $bulan = CH::listBulan();
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
                $q2 = pegawai::leftJoin('absensi_susulan','pegawai.nip','=','absensi_susulan.nip')
                    ->leftJoin('pangkat','pegawai.kd_pangkat','=','pangkat.kd_pangkat')
                    ->leftJoin('jabatan','pegawai.kd_jab','=','jabatan.kd_jabatan')
                    ->leftJoin('satker','absensi_susulan.kd_satker_saat_absensi','=','satker.kd_satker')
                    ->leftJoin('aturan_tunkin_detail',function($q){
                        $q->on('absensi_susulan.kelas_jab_saat_absensi','=','aturan_tunkin_detail.kelas_jabatan');
                        $q->on('aturan_tunkin_detail.id_aturan_tunkin',"absensi_susulan.kd_aturan");
                    })
                    ->where('absensi_susulan.id_waktu',$query[0]['id']);
                    
            }
            else
            {
                $q2 = pegawai::leftJoin('absensi_susulan','pegawai.nip','=','absensi_susulan.nip')
                    ->leftJoin('pangkat','pegawai.kd_pangkat','=','pangkat.kd_pangkat')
                    ->leftJoin('jabatan','pegawai.kd_jab','=','jabatan.kd_jabatan')
                    ->leftJoin('satker','absensi_susulan.kd_satker_saat_absensi','=','satker.kd_satker')
                    ->leftJoin('aturan_tunkin_detail',function($q){
                        $q->on('absensi_susulan.kelas_jab_saat_absensi','=','aturan_tunkin_detail.kelas_jabatan');
                        $q->on('aturan_tunkin_detail.id_aturan_tunkin',"absensi_susulan.kd_aturan");
                    })
                    ->where('absensi_susulan.kd_satker_saat_absensi',CH::getKdSatker(Auth::user()->kd_satker))
                    ->where('absensi_susulan.id_waktu',$query[0]['id']);
            }

            $q2 //->groupBy('pegawai.kelas_jab')
                    ->orderBy('absensi_susulan.kd_satker_saat_absensi','ASC')
                    ->orderBy('absensi_susulan.kd_anak_satker_saat_absensi','ASC')
                    ->orderBy('absensi_susulan.kelas_jab_saat_absensi','DESC')
                    ->selectRaw(DB::raw('pegawai.* ,  aturan_tunkin_detail.tunjangan, absensi_susulan.*')); 
            //cek apakah ada request berdasarkan satker
            if($request->satker != "")
                $q2->where('absensi_susulan.kd_satker_saat_absensi',$request->satker);
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
                
                if (array_key_exists($val->kelas_jab_saat_absensi, $nilaiBalik)) {
                    $nilaiBalik[$val->kelas_jab_saat_absensi]['kelas_jab'] = $val->kelas_jab_saat_absensi;
                    $nilaiBalik[$val->kelas_jab_saat_absensi]['count_orang'] +=1;
                    

                    $nilaiBalik[$val->kelas_jab_saat_absensi]['absensiValue1'] = CH::absensiFormulaMath($formula[0]['rumus'],$val->tunjangan,$val->absensi1);
                    $nilaiBalik[$val->kelas_jab_saat_absensi]['absensiValue2'] = CH::absensiFormulaMath($formula[1]['rumus'],$val->tunjangan,$val->absensi2);
                    $nilaiBalik[$val->kelas_jab_saat_absensi]['absensiValue3'] = CH::absensiFormulaMath($formula[2]['rumus'],$val->tunjangan,$val->absensi3);
                    $nilaiBalik[$val->kelas_jab_saat_absensi]['absensiValue4'] = CH::absensiFormulaMath($formula[3]['rumus'],$val->tunjangan,$val->absensi4);
                    $jumlahPengurangan = intval($nilaiBalik[$val->kelas_jab_saat_absensi]['absensiValue1']+$nilaiBalik[$val->kelas_jab_saat_absensi]['absensiValue2']+$nilaiBalik[$val->kelas_jab_saat_absensi]['absensiValue3']+$nilaiBalik[$val->kelas_jab_saat_absensi]['absensiValue4']);
                    $nilaiBalik[$val->kelas_jab_saat_absensi]['jumlahPengurangan'] += $jumlahPengurangan;
                    

                    $jadiTunjangan = $val->tunjangan-$jumlahPengurangan;
                    $nilaiBalik[$val->kelas_jab_saat_absensi]['indexTunjangan']= $val->tunjangan;
                    $nilaiBalik[$val->kelas_jab_saat_absensi]['tunjangan']+= $val->tunjangan;
                    $nilaiBalik[$val->kelas_jab_saat_absensi]['tunjanganNetto']+= $jadiTunjangan;
                    $nilaiBalik[$val->kelas_jab_saat_absensi]['pph'] += CH::formulaPPH($val->nip,$val->kawin,$val->tanggungan,$val->jenis_kelamin,$val->gapok,$val->tunj_strukfung,$val->tunjangan,$val->tunj_lain);
                    $nilaiBalik[$val->kelas_jab_saat_absensi]['pphNetto'] += CH::formulaPPH($val->nip,$val->kawin,$val->tanggungan,$val->jenis_kelamin,$val->gapok,$val->tunj_strukfung,$jadiTunjangan,$val->tunj_lain);
                }
                else
                {
                    $nilaiBalik[$val->kelas_jab_saat_absensi]['kelas_jab'] = $val->kelas_jab_saat_absensi;
                    $nilaiBalik[$val->kelas_jab_saat_absensi]['count_orang'] = 1;
                    $nilaiBalik[$val->kelas_jab_saat_absensi]['absensiValue1'] = CH::absensiFormulaMath($formula[0]['rumus'],$val->tunjangan,$val->absensi1);
                    $nilaiBalik[$val->kelas_jab_saat_absensi]['absensiValue2'] = CH::absensiFormulaMath($formula[1]['rumus'],$val->tunjangan,$val->absensi2);
                    $nilaiBalik[$val->kelas_jab_saat_absensi]['absensiValue3'] = CH::absensiFormulaMath($formula[2]['rumus'],$val->tunjangan,$val->absensi3);
                    $nilaiBalik[$val->kelas_jab_saat_absensi]['absensiValue4'] = CH::absensiFormulaMath($formula[3]['rumus'],$val->tunjangan,$val->absensi4);
                    $jumlahPengurangan = intval($nilaiBalik[$val->kelas_jab_saat_absensi]['absensiValue1']+$nilaiBalik[$val->kelas_jab_saat_absensi]['absensiValue2']+$nilaiBalik[$val->kelas_jab_saat_absensi]['absensiValue3']+$nilaiBalik[$val->kelas_jab_saat_absensi]['absensiValue4']);
                    $nilaiBalik[$val->kelas_jab_saat_absensi]['jumlahPengurangan'] = $jumlahPengurangan;
                    
                    $jadiTunjangan = $val->tunjangan-$jumlahPengurangan;
                    $nilaiBalik[$val->kelas_jab_saat_absensi]['indexTunjangan']= $val->tunjangan;
                    $nilaiBalik[$val->kelas_jab_saat_absensi]['tunjangan']= $val->tunjangan;
                    $nilaiBalik[$val->kelas_jab_saat_absensi]['tunjanganNetto']= $jadiTunjangan;
                    $nilaiBalik[$val->kelas_jab_saat_absensi]['pph'] = CH::formulaPPH($val->nip,$val->kawin,$val->tanggungan,$val->jenis_kelamin,$val->gapok,$val->tunj_strukfung,$val->tunjangan,$val->tunj_lain);
                    $nilaiBalik[$val->kelas_jab_saat_absensi]['pphNetto'] = CH::formulaPPH($val->nip,$val->kawin,$val->tanggungan,$val->jenis_kelamin,$val->gapok,$val->tunj_strukfung,$jadiTunjangan,$val->tunj_lain);

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
            else if($request->jenis_pegawai == "2")
                $anggota=" Anggota Tipidkor"; 
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
            //
            if(Auth::user()->level == "operator")
                $selectedSatker = satker::where('kd_satker',CH::getKdSatker(Auth::user()->kd_satker))->first();
            else if($request->satker != "")
                $selectedSatker = satker::where('kd_satker',$request->satker)->first();
            else
                $selectedSatker['nm_satker'] = "";
            //
            return ['idBulanTahun' => $query[0]['id'],'status' => 'success','dataAbsensi' => $returnVal,'formula' => $formula,'tunkin' => $tunkin,'words' => $mengenaiWord,'anggota' => $anggota,'satkerNama'=>$satkerNama,'dataTTD' => CH::getTTD($request->halaman,$request->satker),'selectedSatker' => $selectedSatker];            
        }
        else
        {
            return ['status' => 'failed'];
        }
    }

    public function pilihBulanTahunKU(Request $request)
    {
        $bulan = CH::listBulan();
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
                $q2 = pegawai::leftJoin('absensi_susulan','pegawai.nip','=','absensi_susulan.nip')
                    ->leftJoin('pangkat','pegawai.kd_pangkat','=','pangkat.kd_pangkat')
                    ->leftJoin('jabatan','pegawai.kd_jab','=','jabatan.kd_jabatan')
                    ->leftJoin('satker','absensi_susulan.kd_satker_saat_absensi','=','satker.kd_satker')
                    ->leftJoin('aturan_tunkin_detail',function($q){
                        $q->on('absensi_susulan.kelas_jab_saat_absensi','=','aturan_tunkin_detail.kelas_jabatan');
                        $q->on('aturan_tunkin_detail.id_aturan_tunkin',"absensi_susulan.kd_aturan");
                    })
                    ->where('absensi_susulan.id_waktu',$query[0]['id']);
                    
            }
            else
            {
                $q2 = pegawai::leftJoin('absensi_susulan','pegawai.nip','=','absensi_susulan.nip')
                    ->leftJoin('pangkat','pegawai.kd_pangkat','=','pangkat.kd_pangkat')
                    ->leftJoin('jabatan','pegawai.kd_jab','=','jabatan.kd_jabatan')
                    ->leftJoin('satker','absensi_susulan.kd_satker_saat_absensi','=','satker.kd_satker')
                    ->leftJoin('aturan_tunkin_detail',function($q){
                        $q->on('absensi_susulan.kelas_jab_saat_absensi','=','aturan_tunkin_detail.kelas_jabatan');
                        $q->on('aturan_tunkin_detail.id_aturan_tunkin',"absensi_susulan.kd_aturan");
                    })
                    ->where('absensi_susulan.kd_satker_saat_absensi',CH::getKdSatker(Auth::user()->kd_satker))
                    ->where('absensi_susulan.id_waktu',$query[0]['id']);
            }

            $q2 //->groupBy('pegawai.kelas_jab')
                    ->orderBy('absensi_susulan.kd_satker_saat_absensi','ASC')
                    ->orderBy('absensi_susulan.kd_anak_satker_saat_absensi','ASC')
                    ->orderBy('absensi_susulan.kelas_jab_saat_absensi','DESC')
                    ->selectRaw(DB::raw('pegawai.* ,  aturan_tunkin_detail.tunjangan , absensi_susulan.*')); 
            //cek apakah ada request berdasarkan satker
            if($request->satker != "")
                $q2->where('absensi_susulan.kd_satker_saat_absensi',$request->satker);
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
                
                if (array_key_exists($val->kelas_jab_saat_absensi, $nilaiBalik)) {
                    $nilaiBalik[$val->kelas_jab_saat_absensi]['kelas_jab'] = $val->kelas_jab_saat_absensi;
                    $nilaiBalik[$val->kelas_jab_saat_absensi]['count_orang'] +=1;
                    

                    $nilaiBalik[$val->kelas_jab_saat_absensi]['absensiValue1'] = CH::absensiFormulaMath($formula[0]['rumus'],$val->tunjangan,$val->absensi1);
                    $nilaiBalik[$val->kelas_jab_saat_absensi]['absensiValue2'] = CH::absensiFormulaMath($formula[1]['rumus'],$val->tunjangan,$val->absensi2);
                    $nilaiBalik[$val->kelas_jab_saat_absensi]['absensiValue3'] = CH::absensiFormulaMath($formula[2]['rumus'],$val->tunjangan,$val->absensi3);
                    $nilaiBalik[$val->kelas_jab_saat_absensi]['absensiValue4'] = CH::absensiFormulaMath($formula[3]['rumus'],$val->tunjangan,$val->absensi4);
                    $jumlahPengurangan = intval($nilaiBalik[$val->kelas_jab_saat_absensi]['absensiValue1']+$nilaiBalik[$val->kelas_jab_saat_absensi]['absensiValue2']+$nilaiBalik[$val->kelas_jab_saat_absensi]['absensiValue3']+$nilaiBalik[$val->kelas_jab_saat_absensi]['absensiValue4']);
                    $nilaiBalik[$val->kelas_jab_saat_absensi]['jumlahPengurangan'] += $jumlahPengurangan;
                    

                    $jadiTunjangan = $val->tunjangan-$jumlahPengurangan;
                    $nilaiBalik[$val->kelas_jab_saat_absensi]['indexTunjangan']= $val->tunjangan;
                    $nilaiBalik[$val->kelas_jab_saat_absensi]['tunjangan']+= $val->tunjangan;
                    $nilaiBalik[$val->kelas_jab_saat_absensi]['tunjanganNetto']+= $jadiTunjangan;
                    $nilaiBalik[$val->kelas_jab_saat_absensi]['pph'] += CH::formulaPPH($val->nip,$val->kawin,$val->tanggungan,$val->jenis_kelamin,$val->gapok,$val->tunj_strukfung,$val->tunjangan,$val->tunj_lain);
                    $nilaiBalik[$val->kelas_jab_saat_absensi]['pphNetto'] += CH::formulaPPH($val->nip,$val->kawin,$val->tanggungan,$val->jenis_kelamin,$val->gapok,$val->tunj_strukfung,$jadiTunjangan,$val->tunj_lain);
                }
                else
                {
                    $nilaiBalik[$val->kelas_jab_saat_absensi]['kelas_jab'] = $val->kelas_jab_saat_absensi;
                    $nilaiBalik[$val->kelas_jab_saat_absensi]['count_orang'] = 1;
                    $nilaiBalik[$val->kelas_jab_saat_absensi]['absensiValue1'] = CH::absensiFormulaMath($formula[0]['rumus'],$val->tunjangan,$val->absensi1);
                    $nilaiBalik[$val->kelas_jab_saat_absensi]['absensiValue2'] = CH::absensiFormulaMath($formula[1]['rumus'],$val->tunjangan,$val->absensi2);
                    $nilaiBalik[$val->kelas_jab_saat_absensi]['absensiValue3'] = CH::absensiFormulaMath($formula[2]['rumus'],$val->tunjangan,$val->absensi3);
                    $nilaiBalik[$val->kelas_jab_saat_absensi]['absensiValue4'] = CH::absensiFormulaMath($formula[3]['rumus'],$val->tunjangan,$val->absensi4);
                    $jumlahPengurangan = intval($nilaiBalik[$val->kelas_jab_saat_absensi]['absensiValue1']+$nilaiBalik[$val->kelas_jab_saat_absensi]['absensiValue2']+$nilaiBalik[$val->kelas_jab_saat_absensi]['absensiValue3']+$nilaiBalik[$val->kelas_jab_saat_absensi]['absensiValue4']);
                    $nilaiBalik[$val->kelas_jab_saat_absensi]['jumlahPengurangan'] = $jumlahPengurangan;
                    
                    $jadiTunjangan = $val->tunjangan-$jumlahPengurangan;
                    $nilaiBalik[$val->kelas_jab_saat_absensi]['indexTunjangan']= $val->tunjangan;
                    $nilaiBalik[$val->kelas_jab_saat_absensi]['tunjangan']= $val->tunjangan;
                    $nilaiBalik[$val->kelas_jab_saat_absensi]['tunjanganNetto']= $jadiTunjangan;
                    $nilaiBalik[$val->kelas_jab_saat_absensi]['pph'] = CH::formulaPPH($val->nip,$val->kawin,$val->tanggungan,$val->jenis_kelamin,$val->gapok,$val->tunj_strukfung,$val->tunjangan,$val->tunj_lain);
                    $nilaiBalik[$val->kelas_jab_saat_absensi]['pphNetto'] = CH::formulaPPH($val->nip,$val->kawin,$val->tanggungan,$val->jenis_kelamin,$val->gapok,$val->tunj_strukfung,$jadiTunjangan,$val->tunj_lain);

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
            else if($request->jenis_pegawai == "2")
                $anggota=" Anggota Tipidkor"; 
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
            //
            if(Auth::user()->level == "operator")
                $selectedSatker = satker::where('kd_satker',CH::getKdSatker(Auth::user()->kd_satker))->first();
            else if($request->satker != "")
                $selectedSatker = satker::where('kd_satker',$request->satker)->first();
            else
                $selectedSatker['nm_satker'] = "";
            //
            return ['idBulanTahun' => $query[0]['id'],'status' => 'success','dataAbsensi' => $nilaiBalik,'formula' => $formula,'tunkin' => $tunkin,'words' => $mengenaiWord,'anggota'=>$anggota,'satkerNama' => $satkerNama,'dataTTD' => CH::getTTD($request->halaman,$request->satker),'selectedSatker' => $selectedSatker];            
        }
        else
        {
            return ['status' => 'failed'];
        }
    }


    public function pilihBulanTahun(Request $request)
    {
        //cari data yang sesuai
        $bulan = CH::listBulan();
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
                $q2 = pegawai::leftJoin('absensi_susulan','pegawai.nip','=','absensi_susulan.nip')
                    ->leftJoin('pangkat','pegawai.kd_pangkat','=','pangkat.kd_pangkat')
                    ->leftJoin('jabatan','pegawai.kd_jab','=','jabatan.kd_jabatan')
                    ->leftJoin('satker','absensi_susulan.kd_satker_saat_absensi','=','satker.kd_satker')
                    ->leftJoin('anak_satker',function($q){
                        $q->on('absensi_susulan.kd_satker_saat_absensi','=','anak_satker.kd_satker');
                        $q->on('absensi_susulan.kd_anak_satker_saat_absensi','=','anak_satker.kd_anak_satker'); // minta diubah
                    })
                    ->leftJoin('aturan_tunkin_detail',function($q){
                        $q->on('absensi_susulan.kelas_jab_saat_absensi','=','aturan_tunkin_detail.kelas_jabatan'); // ini minta diganti juga
                        $q->on('aturan_tunkin_detail.id_aturan_tunkin','=','absensi_susulan.kd_aturan');
                    })
                    ->where('absensi_susulan.id_waktu',$query[0]['id'])
                    ->where('absensi_susulan.status_dapat','1')
                    ->orderBy('absensi_susulan.kd_satker_saat_absensi','ASC')
                    ->orderBy('absensi_susulan.kd_anak_satker_saat_absensi','ASC')
                    ->orderBy('absensi_susulan.kelas_jab_saat_absensi','DESC')
                    ->select('absensi_susulan.*','pegawai.*','pangkat.*','jabatan.*','satker.*','anak_satker.nm_anak_satker','aturan_tunkin_detail.*');
            }
            else
            {
                $q2 = pegawai::leftJoin('absensi_susulan','pegawai.nip','=','absensi_susulan.nip')
                    ->leftJoin('pangkat','pegawai.kd_pangkat','=','pangkat.kd_pangkat')
                    ->leftJoin('jabatan','pegawai.kd_jab','=','jabatan.kd_jabatan')
                    ->leftJoin('satker','absensi_susulan.kd_satker_saat_absensi','=','satker.kd_satker')
                    ->leftJoin('anak_satker',function($q){
                        $q->on('absensi_susulan.kd_satker_saat_absensi','=','anak_satker.kd_satker');
                        $q->on('absensi_susulan.kd_anak_satker_saat_absensi','=','anak_satker.kd_anak_satker'); // minta diubah
                    })
                    ->leftJoin('aturan_tunkin_detail',function($q){
                        $q->on('absensi_susulan.kelas_jab_saat_absensi','=','aturan_tunkin_detail.kelas_jabatan'); // ini minta diganti juga
                        $q->on('aturan_tunkin_detail.id_aturan_tunkin','=','absensi_susulan.kd_aturan');
                    })
                    ->where('absensi_susulan.kd_satker_saat_absensi',CH::getKdSatker(Auth::user()->kd_satker))
                    ->where('absensi_susulan.id_waktu',$query[0]['id'])
                    ->where('absensi_susulan.status_dapat','1')
                    ->orderBy('absensi_susulan.kd_satker_saat_absensi','ASC')
                    ->orderBy('absensi_susulan.kd_anak_satker_saat_absensi','ASC')
                    ->orderBy('absensi_susulan.kelas_jab_saat_absensi','DESC')
                    ->select('absensi_susulan.*','pegawai.*','pangkat.*','jabatan.*','satker.*','anak_satker.nm_anak_satker','aturan_tunkin_detail.*');      
            }
            //cek apakah ada request berdasarkan satker
            if($request->satker != "")
                $q2->where('absensi_susulan.kd_satker_saat_absensi',$request->satker);
            if($request->anakSatker != "all")
                $q2->where('absensi_susulan.kd_anak_satker_saat_absensi',$request->anakSatker);

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
                $dataSend[$key]['absensiValue1'] = CH::absensiFormulaMath($formula[0]['rumus'],$value->tunjangan,$value->absensi1);
                $dataSend[$key]['absensiValue2'] = CH::absensiFormulaMath($formula[1]['rumus'],$value->tunjangan,$value->absensi2);
                $dataSend[$key]['absensiValue3'] = CH::absensiFormulaMath($formula[2]['rumus'],$value->tunjangan,$value->absensi3);
                $dataSend[$key]['absensiValue4'] = CH::absensiFormulaMath($formula[3]['rumus'],$value->tunjangan,$value->absensi4);
                $dataSend[$key]['jumlahPengurangan'] = intval($dataSend[$key]['absensiValue1']+$dataSend[$key]['absensiValue2']+$dataSend[$key]['absensiValue3']+$dataSend[$key]['absensiValue4']);
                $jadiTunjangan = $value->tunjangan-$dataSend[$key]['jumlahPengurangan'];
                $dataSend[$key]['pajakAwal'] = CH::formulaPPH($value->nip,$value->kawin,$value->tanggungan,$value->jenis_kelamin,$value->gapok,$value->tunj_strukfung,$value->tunjangan,$value->tunj_lain);
                $dataSend[$key]['pajak'] = CH::formulaPPH($value->nip,$value->kawin,$value->tanggungan,$value->jenis_kelamin,$value->gapok,$value->tunj_strukfung,$jadiTunjangan,$value->tunj_lain);
            }
            $satker = satker::select('kd_satker','nm_satker')->get();
            //
            if(Auth::user()->level == "operator")
                $selectedSatker = satker::where('kd_satker',CH::getKdSatker(Auth::user()->kd_satker))->first();
            else if($request->satker != "")
                $selectedSatker = satker::where('kd_satker',$request->satker)->first();
            else
                $selectedSatker['nm_satker'] = "";
            //
            return ['idBulanTahun' => $query[0]['id'],'status' => 'success','dataAbsensi' => $dataSend,'formula' => $formula , 'bulan' => $bulan[$request->bulan] ,'tahun' => $request->tahun ,'keanggotaan' => $keanggotaan ,'satker' => $satker,'selectedSatker' => $selectedSatker];            
        }
        else
        {
            return ['status' => 'failed'];
        }
    }
    public function cekLap()
    {
        $q2 = pegawai::leftJoin('absensi_susulan','pegawai.nip','=','absensi_susulan.nip')
                    ->leftJoin('pangkat','pegawai.kd_pangkat','=','pangkat.kd_pangkat')
                    ->leftJoin('jabatan','pegawai.kd_jab','=','jabatan.kd_jabatan')
                    ->leftJoin('aturan_tunkin_detail',function($q){
                        $q->on('pegawai.kelas_jab','=','aturan_tunkin_detail.kelas_jabatan');
                        $q->on('aturan_tunkin_detail.id_aturan_tunkin',"absensi_susulan.kd_aturan");
                    })
                    
                    
                    ->where('pegawai.kd_satker',"S1")
                    ->where('absensi_susulan.id_waktu',"1")->get(); 
        return $q2;
    }
}
