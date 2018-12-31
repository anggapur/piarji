<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class StateTipidkorsaatabsensi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        // Schema::table('absensi_susulan',function($table){
        //     $table->enum('state_tipikor_saat_absensi',[0,1]);
        // });
        // Schema::table('absensi_kekurangan',function($table){
        //     $table->enum('state_tipikor_saat_absensi',[0,1]);
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
