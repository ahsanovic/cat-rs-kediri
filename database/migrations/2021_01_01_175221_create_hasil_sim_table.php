<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHasilSimTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hasil_sim', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('peserta_sim_id')->reference('id')->on('peserta_sim');
            $table->string('nilaitwk',3);
            $table->string('nilaitiu',3);
            $table->string('nilaitkp',3);
            $table->string('nilai_total',3);
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
        Schema::dropIfExists('hasil_sim');
    }
}
