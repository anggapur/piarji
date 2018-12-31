<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class anak_satker extends Model
{
    //
    protected $table = "anak_satker";
    protected $fillable = ['kd_satker','kd_anak_satker','nm_anak_satker'];
}
