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
        Schema::create('exams', function (Blueprint $table) {
            $table->id('id_ujian');
            $table->bigInteger('id_kelas');
            $table->bigInteger('waktu');
            $table->timestamp('awal');
            $table->timestamp('akhir');
            $table->string('nama_ujian');
            $table->string('link');
            $table->enum('acc', ['y','n']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};
