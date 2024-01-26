<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUjianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ujian', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('peserta_id')->reference('id')->on('peserta');
            $table->string('soal',1000);
            $table->string('jawaban',500);
            $table->string('kunci',500);
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
        Schema::dropIfExists('ujian');
    }
}
