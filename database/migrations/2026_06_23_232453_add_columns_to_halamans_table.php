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
        Schema::table('halamans', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->text('ringkasan')->nullable();
            $table->longText('isi');
            $table->string('foto')->nullable();
            $table->unsignedSmallInteger('urutan')->default(0);
            $table->boolean('is_published')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('halamans', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn(['user_id','judul','slug','ringkasan','isi','foto','urutan','is_published']);
        });
    }
};
