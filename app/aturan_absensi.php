<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class aturan_absensi extends Model
{
    //
    protected $table = "aturan_absensi";
    protected $fillable = ['rumus','nama'];
    protected $dates = ['deleted_at'];
}
