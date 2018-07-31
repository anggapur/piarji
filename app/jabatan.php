<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\softDeletes;
class jabatan extends Model
{
    //
    use SoftDeletes;
    protected $table = "jabatan";
    protected $fillable = ['kd_jabatan','nm_jabatan'];
    protected $dates = ['deleted_at'];
}
