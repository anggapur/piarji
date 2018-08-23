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

        $data['dataSatker'] = [];
        if(Auth::user()->level == "admin")
            $data['dataSatker'] = satker::select('id','kd_satker','nm_satker')->get();

        return view($this->mainPage.".laporanB",$data);
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
                    ->where('pegawai.kd_satker',CH::getKdSatker(Auth::user()->kd_satker))
                    ->where('absensi.id_waktu',$query[0]['id']);
            }

            $q2->groupBy('pegawai.kelas_jab')
                    ->orderBy('pegawai.kelas_jab','DESC')   
                    ->orderBy('pegawai.kd_satker','ASC')
                    ->selectRaw(DB::raw('pegawai.* , count(pegawai.kelas_jab) as countKelasJab , aturan_tunkin_detail.tunjangan')); 
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
            return ['idBulanTahun' => $query[0]['id'],'status' => 'success','dataAbsensi' => $nilaiBalik,'formula' => $formula,'tunkin' => $tunkin];            
        }
        else
        {
            return ['status' => 'failed'];
        }
    }


    public function pilihBulanTahun(Request $request)
    {
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
                    ->where('absensi.id_waktu',$query[0]['id'])
                    ->orderBy('pegawai.kd_satker','ASC');
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
                    ->where('pegawai.kd_satker',CH::getKdSatker(Auth::user()->kd_satker))
                    ->where('absensi.id_waktu',$query[0]['id'])
                    ->orderBy('pegawai.kd_satker','ASC');   
            }
            //cek apakah ada request berdasarkan satker
            if($request->satker != "")
                $q2->where('pegawai.kd_satker',$request->satker);
            //cek apakah di requect polri atau pns
            if($request->jenis_pegawai == "0")
                $q2->whereRaw('LENGTH(pegawai.nip) <= 8'); // polri
            else if($request->jenis_pegawai == "1")
                $q2->whereRaw('LENGTH(pegawai.nip) > 8'); // pns


            return ['idBulanTahun' => $query[0]['id'],'status' => 'success','dataAbsensi' => $q2->get(),'formula' => $formula];            
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
