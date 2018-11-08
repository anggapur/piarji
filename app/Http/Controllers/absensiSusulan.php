<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\pegawai;
use CH;
use Auth;
use App\aturan_absensi;
use App\waktu_absensi;
use App\aturan_tunkin;
use App\absensiSusulan as absensi_susulan;
use App\anak_satker;
class absensiSusulan extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $mainPage = "absensiSusulan";
    public $page = "Absensi Pegawai";
    public function index()
    {
        //
        $data['page'] = $this->page;
        $data['subpage'] = "Form Absensi Susulan";
        $data['dataPegawai'] = pegawai::where('status_aktif','1')
                                ->where('kd_satker',CH::getKdSatker(Auth::user()->kd_satker))
                                ->get();         
        $data['fieldAbsensi'] = aturan_absensi::all();
        $data['tahunTerkecil'] = waktu_absensi::orderBy('tahun','ASC')->first()->tahun;    
        $data['anakSatker'] = anak_satker::where('kd_satker',CH::getKdSatker(Auth::user()->kd_satker))->get();
        return view($this->mainPage.".create",$data);
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
        $kd_aturan  = aturan_tunkin::where('state','1')->first()->id;
        $dataInsert = [];
        $i = 0;
        $delete = absensi_susulan::
                    where('id_waktu',$request->waktu_absensi)
                    ->where('kd_satker_saat_absensi',CH::getKdSatker(Auth::user()->kd_satker))->delete();

        
        if($request->absensi1 != "") :
        foreach ($request->absensi1 as $key => $value) {
            // $cari = absensi_susulan::where('nip',$key)
            //         ->where('id_waktu',$request->waktu_absensi)
            //         ->where('kd_satker_saat_absensi',CH::getKdSatker(Auth::user()->kd_satker));

            // if($cari->get()->count() == 0)
            // {
                $dataInsert[$i]['nip'] = $key;
                $dataInsert[$i]['id_waktu'] = $request->waktu_absensi;
                $dataInsert[$i]['absensi1'] = $value;
                $dataInsert[$i]['absensi2'] = $request->absensi2[$key];
                $dataInsert[$i]['absensi3'] = $request->absensi3[$key];
                $dataInsert[$i]['absensi4'] = $request->absensi4[$key];
                $dataInsert[$i]['kd_anak_satker_saat_absensi'] = $request->kd_anak_satker[$key];
                $dataInsert[$i]['kelas_jab_saat_absensi'] = $request->kelas_jab[$key];
                $dataInsert[$i]['status_dapat'] = "1";
                $dataInsert[$i]['kd_aturan'] = $kd_aturan;
                $dataInsert[$i]['kd_satker_saat_absensi'] = CH::getKdSatker(Auth::user()->kd_satker);
                $i++;
            // }
            // else
            // {   
            //     $dataUpdate['absensi1'] = $value;
            //     $dataUpdate['absensi2'] = $request->absensi2[$key];
            //     $dataUpdate['absensi3'] = $request->absensi3[$key];
            //     $dataUpdate['absensi4'] = $request->absensi4[$key];
            //     $update = $cari->update($dataUpdate);
            // }
        }
        endif;
        $query = absensi_susulan::insert($dataInsert);
        if($query)
            return redirect('absensiSusulan')->with(['status' => 'success' , 'message' => 'Berhasil buat absensi susulan']);
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

    public function cekBulanTahun(Request $request)
    {
        $query = waktu_absensi::where('bulan',$request->bulan)
                                ->where('tahun',$request->tahun);
        if($query->get()->count() == 0)
        {
            $create = waktu_absensi::create(['bulan' => $request->bulan , 'tahun' => $request->tahun]);
            return ['id_waktu_absensi' => $create->id ,'absensi' => [] ,'status' => 'kosong'];
        }
        else
        {
            $absensi = absensi_susulan::where('id_waktu',$query->first()->id)
                            ->leftJoin('pegawai','absensi_susulan.nip','=','pegawai.nip')
                            ->where('kd_satker_saat_absensi',CH::getKdSatker(Auth::user()->kd_satker))
                            ->get();
            return ['id_waktu_absensi' => $query->first()->id ,'absensi' => $absensi ,'status' => 'ada'];
        }
    }
}
