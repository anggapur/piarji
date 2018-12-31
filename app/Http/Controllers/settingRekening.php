<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Yajra\Datatables\Datatables;
use App\pegawai;
use CH;
use Auth;
use Excel;
class settingRekening extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public $mainPage = "settingRekening";
    public $page = "List Data Pegawai";
    public function index()
    {
        $data['page'] = $this->page;
        $data['subpage'] = "List Personil";    
        if(Auth::user()->level == "admin")
            return view($this->mainPage.".indexAdmin",$data);
        else
            return view($this->mainPage.".indexOperator",$data);
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
        $data['page'] = $this->page;
        $data['subpage'] = "Edit Rekening User";                
        $data['dataUser'] = pegawai::where('id',$id)->first();        
        return view($this->mainPage.".edit",$data);
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
        $dataInsert['no_rekening'] = $request->no_rekening;
        $query = pegawai::where('id',$id)->update($dataInsert);
        $data = pegawai::where('id',$id)->first();
        if($query)
        {
            return redirect($this->mainPage)->with(['status' => 'success' ,'message' => "Berhasil Update Pegawai <b>".$data['nama']."</b>"]);
        }
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

    public function importrekening(Request $request)
    {
        $berhasil = "";
        $gagal = "";
        if($request->hasFile('file')){
            $path = $request->file('file')->getRealPath();
            $data = Excel::load($path, function($reader){})->get();
            if(!empty($data) && $data->count()){
                //jika operator
                if(Auth::user()->level == "operator")
                    $where['kd_satker'] = CH::getKdSatker(Auth::user()->kd_satker);

                foreach($data as $key=>$val){
                    $where['nip'] = $val->nip;
                    $update = pegawai::where($where)->update(['no_rekening'=>$val->no_rekening]);
                    if($update)
                        $berhasil.=$val->nip." ,";
                    else
                        $gagal.=$val->nip." ,";
               }
                
                if($berhasil !== "")
                {
                    $mes['status'] = "success";
                    $mes['message']="Data <b>".substr($berhasil,0,-1)."</b> berhasil diupdate <br>";
                }
                if($gagal !== "")
                {   
                    $mes['status2'] = "danger";
                    $mes['message2']="Data <b>".substr($gagal,0,-1)."</b> gagal diupdate";
                }

               return redirect($this->mainPage)->with($mes);   
            }
            else
            {
                return redirect($this->mainPage)->with(['status' => 'success' ,'message' => "Data Kosong"]);   
            }
        }
    }
    public function importForm()
    {                
        $data['page'] = $this->page;
        $data['subpage'] = "Import Rekening User";                        
        return view($this->mainPage.".importForm",$data);
    }

    public function anyData()
    {
        if(Auth::user()->level == "admin")
        {
            $q = pegawai::leftJoin('satker','pegawai.kd_satker','=','satker.kd_satker')
            ->leftJoin('pangkat','pegawai.kd_pangkat','=','pangkat.kd_pangkat')            
            ->leftJoin('jabatan','pegawai.kd_jab','=','jabatan.kd_jabatan')    
            ->where('pegawai.status_aktif','1')        
            ->select('pegawai.*','satker.nm_satker','nm_pangkat1','nm_pangkat2','nm_jabatan');
        }
        else
        {
            $q = pegawai::leftJoin('satker','pegawai.kd_satker','=','satker.kd_satker')
            ->leftJoin('pangkat','pegawai.kd_pangkat','=','pangkat.kd_pangkat')            
            ->leftJoin('jabatan','pegawai.kd_jab','=','jabatan.kd_jabatan')   
            ->where('pegawai.kd_satker',CH::getKdSatker(Auth::user()->kd_satker))  
            ->where('pegawai.status_aktif','1')       
            ->select('pegawai.*','satker.nm_satker','nm_pangkat1','nm_pangkat2','nm_jabatan');
        }
        return Datatables::of($q)
           ->addColumn('action', function ($user) {
                return '<a href="'.url($this->mainPage).'/'.$user->id.'/edit" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit Rekening</a>';
            })
            ->make(true);
    }
}
