<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\dept;
use App\lokasi;
use App\unit;
use App\pangkat;
use App\gapok;
use App\pegawai;
use App\satker;
class apiController extends Controller
{
	public $mainPage = "sinkronisasiData";
    public $page = "Sinkronisasi Data";
	public function index()
	{
		$data['page'] = $this->page;
        $data['subpage'] = "";        
        return view($this->mainPage.".index",$data);
	}
	public function getDataPost(Request $request)
	{
		set_time_limit(0);
		$state = TRUE;
		$kalimat = "";
		if($request->dept == "yes")
		{
			$q1 = $this->getDeptApi();
			if($q1)
				$kalimat.="Departemen,";
			else
				$state = FALSE;
		}
		if($request->lokasi == "yes")
		{
			$q2 = $this->getLokasiApi();
			if($q2)
				$kalimat.="Lokasi,";
			else
				$state = FALSE;
		}
		if($request->unit == "yes")
		{
			$q3 = $this->getUnitApi();
			if($q3)
				$kalimat.="Unit,";
			else
				$state = FALSE;
		}
		if($request->pangkat == "yes")
		{
			$q4 = $this->getPangkatApi();
			if($q4)
				$kalimat.="Pangkat,";
			else
				$state = FALSE;
		}
		if($request->gapok == "yes")
		{
			$q5 = $this->getGapokApi();
			if($q5)
				$kalimat.="Gaji Pokok,";
			else
				$state = FALSE;
		}
		if($request->pegawai == "yes")
		{
			$q6 = $this->getPegawaiApi();
			if($q6)
				$kalimat.="Pegawai,";
			else
				$state = FALSE;
		}
		if($request->satker == "yes")
		{
			$q7 = $this->getSatkerApi();
			if($q7)
				$kalimat.="Satker,";
			else
				$state = FALSE;
		}


		if($state == TRUE)
			return redirect('sinkronisasiData')->with(['status'=>'success','message'=>'<b>'.$kalimat.'</b> berhasil di update']);

	}
    //
    public function getDeptApi()
    {
    	$client = new \GuzzleHttp\Client();
		$res = $client->request('GET', 'http://localhost/apiPRG/deptApi');
		//echo $res->getStatusCode();
		$data = json_decode($res->getBody());    
		$state = TRUE;	
		foreach ($data as $key => $value) {
			$update = dept::where('kd_dept',$value->kddept)->update(['nm_dept'=>$value->nmdept]);
			if(!$update)
			{				
				$insert = dept::create([
					'kd_dept'=>$value->kddept,
					'nm_dept'=>$value->nmdept
				]);
				if(!$insert)
				{
					$state = FALSE;
					break;
				}
			}
		}
		//state
		if($state == TRUE)
			return "Berhasil";
		else
			return "Gagal";
    }
    public function getLokasiApi()
    {
    	$client = new \GuzzleHttp\Client();
		$res = $client->request('GET', 'http://localhost/apiPRG/lokasiApi');
		//echo $res->getStatusCode();
		$data = json_decode($res->getBody());    
		$state = TRUE;	
		foreach ($data as $key => $value) {
			$update = lokasi::where('kd_lokasi',$value->kdlokasi)->update(['nm_lokasi'=>$value->nmlokasi]);
			if(!$update)
			{				
				$insert = lokasi::create([
					'kd_lokasi'=>$value->kdlokasi,
					'nm_lokasi'=>$value->nmlokasi
				]);
				if(!$insert)
				{
					$state = FALSE;
					break;
				}
			}
		}
		//state
		if($state == TRUE)
			return "Berhasil";
		else
			return "Gagal";
    }
    public function getUnitApi()
    {
    	$client = new \GuzzleHttp\Client();
		$res = $client->request('GET', 'http://localhost/apiPRG/unitApi');
		//echo $res->getStatusCode();
		$data = json_decode($res->getBody());    
		$state = TRUE;	
		foreach ($data as $key => $value) {
			$update = unit::where('kd_dept',$value->kddept)
				->where('kd_unit',$value->kdunit)
				->update(['nm_unit'=>$value->nmunit]);
			if(!$update)
			{				
				$insert = unit::create([
					'kd_dept'=>$value->kddept,
					'kd_unit'=>$value->kdunit,
					'nm_unit'=>$value->nmunit
				]);
				if(!$insert)
				{
					$state = FALSE;
					break;
				}
			}
		}
		//state
		if($state == TRUE)
			return "Berhasil";
		else
			return "Gagal";
    }
    public function getPangkatApi()
    {
    	$client = new \GuzzleHttp\Client();
		$res = $client->request('GET', 'http://localhost/apiPRG/pangkatApi');
		//echo $res->getStatusCode();
		$data = json_decode($res->getBody());    
		$state = TRUE;	
		foreach ($data as $key => $value) {
			$update = pangkat::where('kd_pangkat',$value->kdgol)				
				->update(['nm_pangkat1'=>$value->nmgol1,'nm_pangkat2'=>$value->nmgol2,'kd_kelgapok'=>$value->kdkelgapok]);
			if(!$update)
			{				
				$insert = pangkat::create([
					'kd_pangkat'=>$value->kdgol,
					'nm_pangkat1'=>$value->nmgol1,
					'nm_pangkat2'=>$value->nmgol2,
					'kd_kelgapok' => $value->kdkelgapok
				]);
				if(!$insert)
				{
					$state = FALSE;
					break;
				}
			}
		}
		//state
		if($state == TRUE)
			return "Berhasil";
		else
			return "Gagal";
    }
    public function getGapokApi()
    {
    	$client = new \GuzzleHttp\Client();
		$res = $client->request('GET', 'http://localhost/apiPRG/gapokApi');
		//echo $res->getStatusCode();
		$data = json_decode($res->getBody());    
		$state = TRUE;	
		foreach ($data as $key => $value) {
			$update = gapok::where('kdkelgapok',$value->kdkelgapok)	
				->where('kdgapok',$value->kdgapok)			
				->update(['gapok'=>$value->gapok]);
			if(!$update)
			{				
				$insert = gapok::create([
					'kdkelgapok'=>$value->kdkelgapok,
					'kdgapok'=>$value->kdgapok,
					'gapok'=>$value->gapok					
				]);
				if(!$insert)
				{
					$state = FALSE;
					break;
				}
			}
		}
		//state
		if($state == TRUE)
			return "Berhasil";
		else
			return "Gagal";
    }
    public function getPegawaiApi()
    {
    	set_time_limit(0);
    	$client = new \GuzzleHttp\Client();
		$res = $client->request('GET', 'http://localhost/apiPRG/hitungPegawaiApi');
		//echo $res->getStatusCode();
		$count = json_decode($res->getBody());
		$limit = 300;
		$bagi = $count/$limit;
		$bagi = floor($bagi);
		$state = TRUE;
		$insertData = [];
		for($i=0;$i<=$bagi;$i++)
		{
			$req = $client->request('GET','http://localhost/apiPRG/pegawaiApi/'.($limit*$i).'/'.$limit);
			$body = json_decode($req->getBody());
			foreach ($body as $key => $value) {
				$update = pegawai::where('nip',$value->nip)						
					->update([
						'nama'=>$value->nmpeg,
						'kd_satker'=>$value->kdsatker,
						'kd_pangkat'=>$value->kdgol,
						'kd_jab'=>$value->kdjab,
						'kd_gapok'=>$value->kdgapok,
						'no_rekening'=>'',	
						'kelas_jab'=>'',				
					]);
				if(!$update)
				{		
					$dataSementara = [
						'nama'=>$value->nmpeg,
						'nip'=>$value->nip,
						'kd_satker'=>$value->kdsatker,
						'kd_pangkat'=>$value->kdgol,
						'kd_jab'=>$value->kdjab,
						'kd_gapok'=>$value->kdgapok,
						'no_rekening'=>'',	
						'kelas_jab'=>'',			
					];	
					array_push($insertData,$dataSementara);					
				}
			}
			$insert = pegawai::insert($insertData);
			if(!$insert)
			{
				$state = FALSE;
				break;
			}
			unset($insertData);
			$insertData = [];
		}
		if($state == TRUE)
			return "Berhasil";
		else
			return "Gagal";
    }
    public function getSatkerApi()
    {
    	set_time_limit(0);
    	$client = new \GuzzleHttp\Client();
		$res = $client->request('GET', 'http://localhost/apiPRG/hitungSatkerApi');
		//echo $res->getStatusCode();
		$count = json_decode($res->getBody());
		$limit = 300;
		$bagi = $count/$limit;
		$bagi = floor($bagi);
		$state = TRUE;
		$insertData = [];
		for($i=0;$i<=$bagi;$i++)
		{
			$req = $client->request('GET','http://localhost/apiPRG/satkerApi/'.($limit*$i).'/'.$limit);
			$body = json_decode($req->getBody());
			foreach ($body as $key => $value) {
				$update = satker::where('kd_satker',$value->kdsatker)						
					->update([
						'nm_satker'=>$value->nmsatker,									
						'kd_dept'=>$value->kddept,									
						'kd_unit'=>$value->kdunit,									
						'kd_lokasi'=>$value->kdlokasi,															
					]);
				if(!$update)
				{				
					$dataSementara = [
						'kd_satker' => $value->kdsatker,
						'nm_satker'=>$value->nmsatker,									
						'kd_dept'=>$value->kddept,									
						'kd_unit'=>$value->kdunit,									
						'kd_lokasi'=>$value->kdlokasi,				
					];
					array_push($insertData,$dataSementara);					
				}
			}

			$insert = satker::insert($insertData);
			if(!$insert)
			{
				$state = FALSE;
				break;
			}
			unset($insertData);
			$insertData = [];
		}
		if($state == TRUE)
			return "Berhasil";
		else
			return "Gagal";
    }
}
