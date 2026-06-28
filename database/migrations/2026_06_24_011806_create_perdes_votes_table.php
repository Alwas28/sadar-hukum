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
        Schema::create('perdes_votes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('perdes_id')->constrained()->cascadeOnDelete();
            $table->string('nama');
            $table->string('nik', 16);
            $table->enum('suara', ['setuju', 'menolak', 'perbaikan']);
            $table->text('alasan')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();
            $table->unique(['perdes_id', 'nik']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perdes_votes');
    }
};
