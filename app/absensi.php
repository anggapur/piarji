<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class absensi extends Model
{
    //
    protected $table = "absensi";
    protected $fillable = ['nip','id_waktu','absensi1','absensi2','absensi3','absensi4','kd_aturan','kd_satker_saat_absensi'];
}
