<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class satker extends Model
{
    //
    use SoftDeletes;
    protected $table = "satker";
    protected $fillable = ['kd_satker','nm_satker','kd_dept','kd_unit','kd_lokasi'];
}
