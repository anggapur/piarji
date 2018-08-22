<?php
namespace App\Helpers;
 
use Request;
use Auth;
use App\satker;
class customHelper {
    /**
     * @param int $user_id User-id
     * 
     * @return string
     */
    public static function segment($i,$word) {
            
      if (in_array(Request::segment($i),$word))
      	return "active";
      else
      	return "boom";
    }
    public static function getSatker()
    {
      $kd_satker = Auth::user()->kd_satker;
      if(Auth::user()->level == 'admin')
      {
        return "Administrator";
      }
      else
      {
        $query = satker::where('id',$kd_satker)->first();        
        return $query['kd_satker']." - ".$query['nm_satker'];
      }
    }
    public static function adminOnly()
    {
       if(Auth::user()->level == 'admin')
      {
        
      }
      else
      {
        return redirect('error');
      }
    }
    public static function showTo($level)
    {
      if(!in_array(Auth::user()->level, $level))
        return "hide";
    }
    public static function getKdSatker($id)
    {
      $q = satker::where('id',$id)->first();
      return $q->kd_satker;
    }

    public static function currencyIndo($val)
    {
      return number_format($val,0,',','.');
    }
}