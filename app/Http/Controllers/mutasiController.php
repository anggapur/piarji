<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\satker;
use CH;
use App\pegawai;
use Auth;
use App\waktu_absensi;
use App\mutasi;
class mutasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $mainPage = "mutasiSetting";
    public $page = "Mutasi";
    
    public function index()
    {

        $data['bulan'] = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
        $data['dataMutasi'] = mutasi::where('dari_satker',CH::getKdSatker(Auth::user()->kd_satker))
                                ->leftJoin('satker','mutasi.dari_satker','=','satker.kd_satker')
                                ->leftJoin('pegawai','pegawai.nip','=','mutasi.nip')
                                ->select('mutasi.*','satker.nm_satker','pegawai.nama')
                                ->get();
        $data['page'] = $this->page;
        $data['subpage'] = "Daftar Mutasi"; 
        
        return view($this->mainPage.".index",$data);
    }
    public function kirimMutasi()
    {
        $data['page'] = $this->page;
        $data['subpage'] = "Kirim Mutasi"; 
        $data['dataSatker'] = satker::select('id','kd_satker','nm_satker')
                                ->where('kd_satker','<>',CH::getKdSatker(Auth::user()->kd_satker))->get();
        $data['tahunTerkecil'] = waktu_absensi::orderBy('tahun','ASC')->first()->tahun;   
        $data['dataPegawai'] = pegawai::where('kd_satker',CH::getKdSatker(Auth::user()->kd_satker))->get();
        
        return view($this->mainPage.".kirimMutasi",$data);
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
        $query = mutasi::where(['dari_satker' => CH::getKdSatker(Auth::user()->kd_satker) , 'nip' => $request->nip])
                        ->where(function($q) use($request){
                            $q->where('ke_satker','out');
                            $q->orWhere('status_terima','1');
                            $q->orWhere('status_terima','0');
                        });
        // return $query->get();
        if($query->get()->count() == 0)
        {
            if($request->mutasi_ke == "dalam")
            {
                $data['nip'] = $request->nip;
                $data['dari_satker'] = CH::getKdSatker(Auth::user()->kd_satker);
                $data['ke_satker'] = $request->ke_satker;
                $data['bulan_keluar'] = $request->bulan_keluar;
                $data['tahun_keluar'] = $request->tahun_keluar;
                $data['bulan_diterima'] = "";
                $data['tahun_diterima'] = "";
                $data['status_terima'] = "0";
            }
            else if($request->mutasi_ke == "keluar")
            {
                $data['nip'] = $request->nip;
                $data['dari_satker'] = CH::getKdSatker(Auth::user()->kd_satker);
                $data['ke_satker'] = "out";
                $data['bulan_keluar'] = $request->bulan_keluar;
                $data['tahun_keluar'] = $request->tahun_keluar;
                $data['bulan_diterima'] = "";
                $data['tahun_diterima'] = "";
                $data['status_terima'] = "0";
            }
            $query = mutasi::create($data);
            $query2 = pegawai::where('nip',$request->nip)->update(['status_aktif'=>'0']);
            if($query)
                return redirect($this->mainPage)->with(['status' => 'success' ,'message' => 'Berhasil mutasi pegawai']);
        }
        else
        {
            if($query->first()->ke_satker == "out")
                return redirect()->back()->with(['status' => 'danger' ,'message' => 'Gagal mutasi, pegawai '.$request->nip.' sudah dimutasi keluar polda Bali dari satker ini']);       
            else if($query->first()->status_terima == "1")
                return redirect()->back()->with(['status' => 'danger' ,'message' => 'Gagal mutasi, pegawai '.$request->nip.' sudah diterima di satker '.$query->first()->ke_satker]);       
            else if($query->first()->status_terima == "0")                
                return redirect()->back()->with(['status' => 'danger' ,'message' => 'Gagal mutasi, pegawai '.$request->nip.' sedang dimutasi ke satker '.$query->first()->ke_satker.', batalkan mutasi terlebih dahulu']);       

        }
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
        return $id."edit";
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
        return $id."dupate";
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

        
        $query = mutasi::where('id',$id)->first();
        if($query->status_terima == "1")
            return redirect()->back()->with(['status' => 'danger' ,'message' => 'Gagal Hapus mutasi, pegawai '.$request->nip.' sudah diterima di satker '.$query->first()->ke_satker]);       

        $data = mutasi::where('id',$id)->first();
        $q = mutasi::where('id',$id)->delete();
        $query2 = pegawai::where('nip',$data->nip)->update(['status_aktif'=>'1']);
        if($q)
            return redirect()->back()->with(['status' => 'success' ,'message' => 'Berhasil Hapus Mutasi']);       
    }
}
