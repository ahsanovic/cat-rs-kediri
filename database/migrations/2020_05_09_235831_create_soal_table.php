<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('soal', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('deskripsi');
            $table->integer('jenis_id');
            $table->integer('bidang_id');
            $table->integer('subbidang_id');
            $table->string('opsi1', 500);
            $table->string('opsi2', 500);
            $table->string('opsi3', 500);
            $table->string('opsi4', 500);
            $table->string('opsi5', 500);
            $table->string('jawaban', 10);
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
        Schema::dropIfExists('soal');
    }
}
