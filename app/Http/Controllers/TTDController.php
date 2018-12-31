<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TTD;
use Auth;
class TTDController extends Controller
{
	public $mainPage = "TTD";
    public $page = "Tanda Tangan Setting";
    public function laporan1()
    {
    	$data['page'] = $this->page;
        $data['subpage'] = "Laporan C1/C2";  
        $data['dataTTD'] = TTD::where(['halaman' => '1','kd_satker' => Auth::user()->kd_satker])->get();        
        return view($this->mainPage.".laporan1",$data);    
    }
     public function laporanB()
    {
    	$data['page'] = $this->page;
        $data['subpage'] = "Laporan B1/B2";  
        $data['dataTTD'] = TTD::where(['halaman' => '2','kd_satker' => Auth::user()->kd_satker])->get();        
        
        return view($this->mainPage.".laporanB",$data);    
    }
    public function laporanSPP()
    {
        $data['page'] = $this->page;
        $data['subpage'] = "Laporan SPP";  
        $data['dataTTD'] = TTD::where(['halaman' => '3','kd_satker' => Auth::user()->kd_satker])->get();        
        //return $data['dataTTD'];
        return view($this->mainPage.".laporanSPP",$data);    
    }
    public function laporanSPTJM()
    {
        $data['page'] = $this->page;
        $data['subpage'] = "Laporan SPP";  
        $data['dataTTD'] = TTD::where(['halaman' => '5','kd_satker' => Auth::user()->kd_satker])->get();        
        //return $data['dataTTD'];
        return view($this->mainPage.".laporanSPTJM",$data);    
    }
    public function laporanKU()
    {
        $data['page'] = $this->page;
        $data['subpage'] = "Laporan SPP";  
        $data['dataTTD'] = TTD::where(['halaman' => '4','kd_satker' => Auth::user()->kd_satker])->get();        
        //return $data['dataTTD'];
        return view($this->mainPage.".laporanKU",$data);    
    }
    public function saveData(Request $request)
    {
       
    	foreach ($request->data as $key => $value) {
    		foreach ($value as $key2 => $val) {
    			//cari
    			$cari = TTD::where(['halaman' => $key , 'bagian' => $key2,'kd_satker' => Auth::user()->kd_satker]);
    			if(array_key_exists('nilai1', $val))
    				$dataInput['nilai1'] = $val['nilai1'];
    			if(array_key_exists('nilai2', $val))
    				$dataInput['nilai2'] = $val['nilai2'];
    			if(array_key_exists('nilai3', $val))
    				$dataInput['nilai3'] = $val['nilai3'];
    			if(array_key_exists('nilai4', $val))
    				$dataInput['nilai4'] = $val['nilai4'];
                if(array_key_exists('nilai5', $val))
                    $dataInput['nilai5'] = $val['nilai5'];

    			$dataInput['halaman'] = $key;
    			$dataInput['bagian'] = $key2;
    			$dataInput['kd_satker'] = Auth::user()->kd_satker;
    			if($cari->get()->count() == 0) 
                {   			
                    if($request->hasFile('image'.$key2))
                    {
                        $image = $request->file('image'.$key2);
                        $name = time().'.'.$image->getClientOriginalExtension();
                        $dataInput['image'] = $name;
                        $destinationPath = public_path('/images');
                        $image->move($destinationPath, $name);

                    }
                    else
                    {
                        $dataInput['image'] = "";
                    }
    				$query = TTD::create($dataInput);    			
                }
    			else
                {
                    if($request->hasFile('image'.$key2))
                    {
                        $image = $request->file('image'.$key2);
                        $name = time().'.'.$image->getClientOriginalExtension();
                        $dataInput['image'] = $name;
                        $destinationPath = public_path('/images');
                        $image->move($destinationPath, $name);

                    }
    				$query = $cari->update($dataInput);
                }
                unset($dataInput);
    		}
    	}

    	if($query)
    		return redirect()->back()->with(['status' => 'success' , 'message' => 'Berhasil Simpan TTD']);
    }
    public function deleteImageTTD(Request $request)
    {
        $query = TTD::where('id',$request->id)->update(['image' => '']);
        if($query)
            return ["status" => "success"];
    }
}
