<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\aturan_absensi;

use App\Helpers\customHelper as CH;
class kebijakanAbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $mainPage = "kebijakanAbsensi";
    public $page = "Kebijakan Absensi";
    public function index()
    {
        CH::adminOnly();
        $data['page'] = $this->page;
        $data['subpage'] = "";    
        $data['dataKebijakan'] = aturan_absensi::all();
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
       
       CH::adminOnly();
        //update data
        foreach ($request->nama as $key => $value) {
            # code...
            echo $key." ".$value."  = ".$request->rumus[$key]."<br>";
            $data['nama'] = $value;
            $data['rumus'] = str_replace("IT","G",$request->rumus[$key]);
            $query = aturan_absensi::where('id',$key)->update($data);
        }
        if($query)
        {
            return redirect($this->mainPage)->with(['status' => 'success' ,'message' => "Berhasil Update Kebijakan Absensi"]);
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
}
