<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class aturan_tunkin_detail extends Model
{
    //
    protected $table = "aturan_tunkin_detail";
    protected $fillable = ["id_aturan_tunkin","kelas_jabatan","tunjangan"];
}
