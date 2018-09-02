<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\pegawai;
use App\User;
use CH;
use DB;
use File;
use Illuminate\Support\Facades\Schema;
use Artisan;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function cobaImport()
    {
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
        $q = DB::unprepared(File::get('public/backupMysql/db_prg.sql')); 
        if($q)
            return "Berhasil";
        else
            return "Gagal";
            
        
    }
    public function index()
    {
        //cari jumlah pegawai             
        if(Auth::user()->level == "admin")
        {
            $data['jumlahPegawai'] = pegawai::get()->count();
            $data['jumlahOperator'] = User::where('level','!=','admin')->get()->count();            
        }
        else
        {
            $data['jumlahPegawai'] = pegawai::where('kd_satker',CH::getKdSatker(Auth::user()->kd_satker))->get()->count();
        }

        $data['page'] = "Dashboard";
        $data['subpage'] = "";
        return view('home',$data);
    }

    public function mathFormula()
    {
        $formula = "G*H";
        $formula = str_replace("G","1000000",$formula);        
        $formula = str_replace("H","0.05",$formula);
        $formula = "0.005*3717000*1";      
        eval( '$result = (' . $formula. ');' );
        echo $result;
    }

    public function formulaPPH()
    {
        $tanggunganArray = ['18','38','48'];

        $query = pegawai::where('nip','81051411')->first();

        echo CH::formulaPPH($query->kawin,$query->tanggungan,$query->jenis_kelamin,$query->gapok,$query->tunj_strukfung,'11024000',$query->tunj_lain);
    }
}
