<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TTD extends Model
{
    //
    protected $table = "ttd";
    protected $fillable = ["halaman","bagian","nilai1","nilai2","nilai3","nilai4","nilai5","kd_satker","image"];
}
