<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class unit extends Model
{
    //
    use SoftDeletes;
    protected $table = "unit";
    protected $fillable = ['kd_dept','kd_unit','nm_unit'];
    
}
