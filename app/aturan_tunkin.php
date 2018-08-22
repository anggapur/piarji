<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class aturan_tunkin extends Model
{
    //
    protected $table = "aturan_tunkin";
    protected $fillable = ['kd_aturan','nama_aturan','state'];

    public function detailAturanTunkinDetail()
    {
    	return $this->hasMany('App\aturan_tunkin_detail','id_aturan_tunkin','id');
    }
}
