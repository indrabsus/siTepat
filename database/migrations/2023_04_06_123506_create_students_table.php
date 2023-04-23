<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id('nis');
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_kelas');
            $table->bigInteger('tahun_masuk');
            $table->enum('jenkel',['l','p']);
            $table->string('no_hp');
            $table->foreign('id_user')->references('id')->on('users');
            $table->foreign('id_kelas')->references('id_kelas')->on('groups');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
