<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pangkat extends Model
{
    //    
    protected $table = "pangkat";
    protected $fillable = ['kd_pangkat','nm_pangkat1','nm_pangkat2','kd_kelgapok'];
    
}

