<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PerdesVote extends Model
{
    protected $table = 'perdes_votes';

    protected $fillable = ['perdes_id', 'nama', 'nik', 'suara', 'alasan', 'ip_address'];

    public function perdes(): BelongsTo
    {
        return $this->belongsTo(Perdes::class);
    }

    public static function suaraLabel(string $suara): string
    {
        return match($suara) {
            'setuju'    => 'Setuju',
            'menolak'   => 'Menolak',
            'perbaikan' => 'Perlu Perbaikan',
            default     => $suara,
        };
    }

    public static function suaraColor(string $suara): string
    {
        return match($suara) {
            'setuju'    => 'hijau',
            'menolak'   => 'red',
            'perbaikan' => 'amber',
            default     => 'gray',
        };
    }

    public function nikCensored(): string
    {
        return substr($this->nik, 0, 4) . str_repeat('*', 8) . substr($this->nik, -4);
    }
}
