<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class satker extends Model
{
    //
    
    protected $table = "satker";
    protected $fillable = ['kd_satker','nm_satker','kd_dept','kd_unit','kd_lokasi'];

    public function getPegawai()
    {
    	return $this->hasMany('App\pegawai','kd_satker','kd_satker');
    }
    public function getAnakSatker()
    {
    	return $this->hasMany('App\anak_satker','kd_satker','kd_satker');
    }
    public function getDataAmprahanPolri()
    {
        return $this->hasMany('App\amprahan','kd_satker_saat_amprah','kd_satker');
    }
    public function getDataAmprahanPns()
    {
        return $this->hasMany('App\amprahan','kd_satker_saat_amprah','kd_satker');
    }
    public function getDataAmprahanTipidkor()
    {
        return $this->hasMany('App\amprahan','kd_satker_saat_amprah','kd_satker');
    }
}
