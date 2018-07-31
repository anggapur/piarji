<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;
class dept extends Model
{
    //
    use softDeletes;
    protected $table = "dept";
    protected $fillable = ['kd_dept','nm_dept'];
    protected $dates = ['deleted_at'];
}
