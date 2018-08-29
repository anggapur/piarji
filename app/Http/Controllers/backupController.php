<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use File;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Schema;
class backupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $mainPage = "backupRestore";
    public $page = "Backup & Restore";
    public function backupView()
    {
        $data['files'] = array_sort(File::files('public\backupMysql'));
        
        $data['page'] = $this->page;
        $data['subpage'] = "Backup"; 
        return view($this->mainPage.".backupView",$data);
    }
    public function restoreView()
    {        
        
        $data['page'] = $this->page;
        $data['subpage'] = "Restore"; 
        return view($this->mainPage.".restoreView",$data);
    }
    public function index()
    {
        //
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
        $imageName = explode('.',$request->file('uploadFile')->getClientOriginalName());

        if($imageName[1] == "sql")
        {
            $time = Carbon::now()->format('Y-m-d-h-i-s');
            $filename =  $imageName[0]."-upload-".$time.".".$imageName[1];
            
            $move = $request->file('uploadFile')->move(
                base_path() . '/public/restoreMysql/', $filename
            );

            set_time_limit(0);

            DB::statement("SET foreign_key_checks=0");
            $databaseName = DB::getDatabaseName();
            $tables = DB::select("SELECT * FROM information_schema.tables WHERE table_schema = '$databaseName'");
            foreach ($tables as $table) {
                $name = $table->TABLE_NAME;
                //if you don't want to truncate migrations
                //if ($name !== 'migrations') {
                    echo $name;
                    // DB::table($name)->truncate();
                    Schema::drop($name);    
                //}
                
            }
            DB::statement("SET foreign_key_checks=1");
            $restore = DB::unprepared(File::get('public/restoreMysql/'.$filename)); 


            if($move && $restore)
                return redirect('backupRestore/restore')->with(['status'=>'success','message'=>'Berhasil Restore Data']);
        }
        else
        {
            return redirect()->back()->with(['status'=>'danger','message'=>'File Yang digunakan tidak valid']);
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
