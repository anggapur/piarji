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
}
