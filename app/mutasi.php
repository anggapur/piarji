<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class mutasi extends Model
{
    //
    protected $table ="mutasi";
    protected $fillable = ['nip','dari_satker','ke_satker','bulan_keluar','tahun_keluar','bulan_diterima','tahun_diterima','status_terima','status_cek'];
}
