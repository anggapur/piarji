<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;

class pegawai extends Model
{
    //
    use SoftDeletes;
    protected $table = "pegawai";
    protected $fillable = ['nama','nip','kd_satker','kd_pangkat','kd_jab','no_rekening',''];
    protected $dates = ['deleted_at'];
}

