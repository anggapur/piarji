<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;
class unit extends Model
{
    //
    use SoftDeletes;
    protected $table = "unit";
    protected $fillable = ['kd_dept','kd_unit','nm_unit'];
    protected $dates = ['deleted_at'];
}
