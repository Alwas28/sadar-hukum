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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('penduduk_id')->nullable()->unique()->constrained('penduduks')->nullOnDelete()->after('id');
            $table->enum('role', ['admin', 'warga'])->default('warga')->after('email');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['penduduk_id']);
            $table->dropColumn(['penduduk_id', 'role']);
        });
    }
};
