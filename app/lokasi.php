<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;

class lokasi extends Model
{
    //
    use SoftDeletes;
    protected $table = "lokasi";
    protected $fillable = ['kd_lokasi','nm_lokasi'];
    protected $dates = ['deleted_at'];
}
