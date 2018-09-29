<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class pegawai extends Model
{
    //    
    protected $table = "pegawai";
    protected $fillable = ['nama','nip','status_aktif','kd_satker','kd_anak_satker','kd_pangkat','kd_jab','no_rekening','kd_gapok','kelas_jab','kawin','tanggungan','jenis_kelamin','gapok','tunj_strukfung','tunj_lain','state_tipikor'];    
}

