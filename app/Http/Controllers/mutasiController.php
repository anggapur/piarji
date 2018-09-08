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
        if($query)
            return redirect($this->mainPage)->with(['status' => 'success' ,'message' => 'Berhasil mutasi pegawai']);
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
}
