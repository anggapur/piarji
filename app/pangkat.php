<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\softDeletes;

class pangkat extends Model
{
    //
    use SoftDeletes;
    protected $table = "pangkat";
    protected $fillable = ['kd_pangkat','nm_pangkat','kd_kelgapok'];
    protected $dates = ["deleted_at"];
}

