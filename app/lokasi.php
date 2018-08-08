<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class lokasi extends Model
{
    //
    use SoftDeletes;
    protected $table = "lokasi";
    protected $fillable = ['kd_lokasi','nm_lokasi'];
    
}
