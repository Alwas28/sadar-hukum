<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pengumuman extends Model
{
    protected $table = 'pengumumans';

    protected $fillable = [
        'user_id', 'tipe', 'kategori', 'judul', 'slug', 'ringkasan',
        'isi', 'gambar', 'tanggal_publikasi', 'is_published',
    ];

    protected $casts = [
        'tanggal_publikasi' => 'date',
        'is_published'      => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true)->orderByDesc('tanggal_publikasi');
    }

    public function indexRoute(): string
    {
        return $this->tipe === 'berita'
            ? route('admin.berita.index')
            : route('admin.pengumuman.index');
    }
}
