<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAmprahansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amprahan', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nip');
            $table->string('id_waktu');
            $table->string('absensi1');
            $table->string('absensi2');
            $table->string('absensi3');
            $table->string('absensi4');
            $table->string('kd_aturan');
            $table->string('kd_satker_saat_amprah');
            $table->string('kd_anak_satker_saat_amprah');
            $table->string('kelas_jab_saat_amprah');
            $table->string('status_dapat');
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
        Schema::dropIfExists('amprahans');
    }
}
