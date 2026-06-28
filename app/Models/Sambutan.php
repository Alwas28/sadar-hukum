<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sambutan extends Model
{
    protected $fillable = ['user_id', 'judul', 'acara', 'catatan', 'isi'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function acaraOptions(): array
    {
        return [
            'HUT Kemerdekaan RI',
            'HUT Desa',
            'Musyawarah Desa (Musdes)',
            'Musrenbangdes',
            'Rapat Desa',
            'Hari Raya Idul Fitri',
            'Hari Raya Idul Adha',
            'Isra Mi\'raj',
            'Maulid Nabi',
            'Hari Jadi Kabupaten',
            'Pelantikan Perangkat Desa',
            'Posyandu / Kesehatan',
            'Peringatan Hari Pendidikan',
            'Kegiatan Karang Taruna',
            'Pembangunan / Peresmian',
            'Penyaluran Bantuan Sosial',
            'Lainnya',
        ];
    }
}
