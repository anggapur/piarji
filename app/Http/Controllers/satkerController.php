<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\satker;
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
    public function anyData()
    {
        $q = satker::leftJoin('dept','satker.kd_dept','=','dept.kd_dept')
            ->leftJoin('unit','satker.kd_unit','=','unit.kd_unit')
            ->leftJoin('lokasi','satker.kd_lokasi','=','lokasi.kd_lokasi')
            ->select('satker.id','kd_satker','nm_satker','dept.kd_dept','dept.nm_dept','unit.kd_unit','unit.nm_unit','lokasi.kd_lokasi','nm_lokasi');            
        return Datatables::of($q)
            /*->addColumn('action', function ($user) {
                return '<a href="#edit-'.$user->id.'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
                
            })*/
            ->make(true);
    }
}
