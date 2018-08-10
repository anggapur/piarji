<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class pegawai extends Model
{
    //    
    protected $table = "pegawai";
    protected $fillable = ['nama','nip','kd_satker','kd_pangkat','kd_jab','no_rekening','kd_gapok','kelas_jab'];    
}

