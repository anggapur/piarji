<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TTDTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('TTD', function (Blueprint $table) {
            $table->increments('id');
            $table->string('halaman');
            $table->string('bagian');
            $table->string('nilai1');
            $table->string('nilai2');
            $table->string('nilai3');
            $table->string('nilai4');
            $table->timestamps();
        });
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
