<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\pegawai;
use App\User;
use CH;
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
}
