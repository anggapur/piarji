<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class jabatan extends Model
{
    //    
    protected $table = "jabatan";
    protected $fillable = ['kd_jabatan','nm_jabatan'];
    
}
