<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class dept extends Model
{
    //    
    protected $table = "dept";
    protected $fillable = ['kd_dept','nm_dept'];
    
}
