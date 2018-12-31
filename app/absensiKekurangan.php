<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class absensiKekurangan extends Model
{
    //
    protected $table = "absensi_kekurangan";
    protected $fillable = ['nip','id_waktu','absensi1','absensi2','absensi3','absensi4','kd_aturan','kd_satker_saat_absensi','kd_anak_satker_saat_absensi','kelas_jab_saat_absensi','status_dapat','state_tipikor_saat_absensi'];
}
