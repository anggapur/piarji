<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class waktu_absensi extends Model
{
    //
    protected $table = "waktu_absensi";
    protected $fillable = ['bulan','tahun'];
}
