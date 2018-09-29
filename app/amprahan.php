<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class amprahan extends Model
{
    //
    protected $table = "amprahan";
    protected $fillable = ['nip','id_waktu','kd_aturan','kd_satker_saat_amprah','kd_anak_satker_saat_amprah','kelas_jab_saat_amprah','status_dapat','state_tipikor_saat_amprah'];
}
