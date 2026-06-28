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
        Schema::create('idms', function (Blueprint $table) {
            $table->id();
            $table->year('tahun')->unique();
            $table->enum('status', ['Sangat Tertinggal', 'Tertinggal', 'Berkembang', 'Maju', 'Mandiri']);
            $table->decimal('skor_idm', 5, 4);
            $table->decimal('skor_iks', 5, 4)->comment('Indeks Ketahanan Sosial');
            $table->decimal('skor_ike', 5, 4)->comment('Indeks Ketahanan Ekonomi');
            $table->decimal('skor_ikl', 5, 4)->comment('Indeks Ketahanan Lingkungan');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('idms');
    }
};
