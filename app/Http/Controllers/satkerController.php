<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\satker;
use Auth;
use Excel;
use Validator;
use App\anak_satker;
class satkerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $mainPage = "dataSatker";
    public $page = "Data Satker";
    public function index()
    {
        $data['page'] = $this->page;
        $data['subpage'] = "List Satker";    
        return view($this->mainPage.".index",$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $data['page'] = $this->page;
        $data['subpage'] = "Input Data Satker";                 
        return view($this->mainPage.".create",$data);
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
        $request->validate([
            'kd_satker' => 'required|unique:satker',
            'nm_satker' => 'required',
        ]);

        $data['kd_satker'] = $request->kd_satker;
        $data['nm_satker'] = $request->nm_satker;
        $data['kd_dept'] = "";
        $data['kd_unit'] = "";
        $data['kd_lokasi'] = "";
        $query = satker::create($data);

        $kd_anak_satker = $request->kd_anak_satker;
        $nm_anak_satker = $request->nm_anak_satker;

        foreach ($kd_anak_satker as $key => $value) {
            $dataInsert['kd_satker'] = $request->kd_satker;
            $dataInsert['kd_anak_satker'] = $value;
            $dataInsert['nm_anak_satker'] = $nm_anak_satker[$key];
            $querys = anak_satker::create($dataInsert);
        }

        if($query)
            return redirect($this->mainPage)->with(['status' => 'success' ,'message' => 'Berhasil Tambah Satker']);
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
        $data['dataSatker'] = satker::where('id',$id)->first();
        $data['page'] = $this->page;
        $data['subpage'] = "Edit Data Satker";                 
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
        $request->validate([            
            'nm_satker' => 'required',
        ]);
        
        $data['nm_satker'] = $request->nm_satker;        
        $query = satker::where('id',$id)->update($data);

        //hapus semua anak satker
        $kd_satker = satker::where('id',$id)->first()->kd_satker;
        $delete = anak_satker::where('kd_satker',$kd_satker)->delete();

        $kd_anak_satker = $request->kd_anak_satker;
        $nm_anak_satker = $request->nm_anak_satker;

        foreach ($kd_anak_satker as $key => $value) {
            $dataInsert['kd_satker'] = $request->kd_satker;
            $dataInsert['kd_anak_satker'] = $value;
            $dataInsert['nm_anak_satker'] = $nm_anak_satker[$key];
            $querys = anak_satker::create($dataInsert);
        }

        if($query)
            return redirect($this->mainPage)->with(['status' => 'success' ,'message' => 'Berhasil Update Satker']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     public function formImport()
    {
        $data['page'] = $this->page;
        $data['subpage'] = "Form Import Data Satker";    
        return view($this->mainPage.".formImport",$data);
    }

    public function destroy($id)
    {
        //
    }
    public function anyData()
    {
        $q = satker::with('getAnakSatker')
            ->leftJoin('dept','satker.kd_dept','=','dept.kd_dept')
            ->leftJoin('unit','satker.kd_unit','=','unit.kd_unit')
            ->leftJoin('lokasi','satker.kd_lokasi','=','lokasi.kd_lokasi')
            ->select('satker.id','kd_satker','nm_satker','dept.kd_dept','dept.nm_dept','unit.kd_unit','unit.nm_unit','lokasi.kd_lokasi','nm_lokasi');            
        return Datatables::of($q)
            ->addColumn('kolom_anak_satker', function ($user) {
                $returnVal = "";
                foreach ($user->getAnakSatker as $key => $value) {
                    $returnVal.='<span class="label label-default" style="margin-right:10px;">'.$value->kd_anak_satker.'-'.$value->nm_anak_satker.'</span>';
                }
                return $returnVal;
                
            })
            ->addColumn('action', function ($user) {
                return '<a href="'.url('dataSatker/'.$user->id).'/edit" class="btn btn-xs btn-warning"> Edit</a>';

                
            })
            ->rawColumns(['kolom_anak_satker', 'action'])
            ->make(true);
    }


    public function importDataSatker(Request $request)
    {
        $berhasil = "";
        $gagal = "";
        $updateCount = 0;
        $insertCount = 0;
        if(Auth::user()->level != "admin")
        {
            return redirect('error');
        }

        if($request->hasFile('file')){
            $path = $request->file('file')->getRealPath();
            $data = Excel::load($path, function($reader){})->get();
            if(!empty($data) && $data->count()){
                $dataInsert = [];                

                foreach($data as $key=>$val){  
                    if($val->kd_satker == null || $val->nm_satker == null)             
                        continue;
                    $cari = satker::where('kd_satker',$val->kd_satker);
                    if($cari->get()->count() == 0)
                    {
                        $datas['kd_satker'] = $val->kd_satker;
                        $datas['nm_satker'] = $val->nm_satker;

                        $messages = [
                            'required' => 'Gagal Import Data, Pastikan Kolom <b> :attribute </b> Diisi / Tidak Kosong',
                        ];
                        $validation = Validator::make($datas,[
                            'kd_satker' => 'required',
                            'nm_satker' => 'required',                            
                        ],$messages)->validate();

                        $create = satker::create($datas);
                        if($create)
                            $insertCount++;

                    }
                    else
                    {   
                        $datas['nm_satker'] = $val->nm_satker;
                        $update = satker::where('kd_satker',$val->kd_satker)->update($datas);
                        if($update)
                            $updateCount++;

                    }

                    $delete = anak_satker::where('kd_satker',$val->kd_satker)->delete();

                    $anak_satker = explode(",",$val->anak_satker);
                    if(count($anak_satker) !== 0)
                    {
                        foreach ($anak_satker as $key => $values) {
                            $datasAnakSatker = explode("-",$values);
                            if(count($datasAnakSatker) == 2)
                            {
                                if($datasAnakSatker[0] == "" || $datasAnakSatker[1] == "")
                                    continue;
                                $dataInsertAnakSatker['kd_satker'] = $val->kd_satker;                            
                                //return $datasAnakSatker[1];
                                $dataInsertAnakSatker['kd_anak_satker'] = $datasAnakSatker[0];
                                $dataInsertAnakSatker['nm_anak_satker'] = $datasAnakSatker[1];
                                $query = anak_satker::create($dataInsertAnakSatker);
                            }
                            else
                            {
                                continue;
                            }
                        }
                    }
                }
                
                    return redirect('dataSatker/importSatker')->with(['status' => 'success' ,'message' => 'Berhasil Import Data Satker. Insert Data Baru '.$insertCount.' , Update Data '.$updateCount]);
            }
            else
            {
                return redirect()->back()->with(['status' => 'danger' ,'message' => 'File Kosong tidak dapat di import']);
            }
        }
    }
}
