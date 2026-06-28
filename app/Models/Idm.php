<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Idm extends Model
{
    protected $table = 'idms';

    protected $fillable = [
        'tahun', 'status', 'skor_idm', 'skor_iks', 'skor_ike', 'skor_ikl', 'keterangan',
    ];

    protected $casts = [
        'skor_idm' => 'float',
        'skor_iks' => 'float',
        'skor_ike' => 'float',
        'skor_ikl' => 'float',
    ];

    public static function statusOptions(): array
    {
        return ['Sangat Tertinggal', 'Tertinggal', 'Berkembang', 'Maju', 'Mandiri'];
    }

    public static function statusFromSkor(float $skor): string
    {
        return match(true) {
            $skor < 0.491 => 'Sangat Tertinggal',
            $skor < 0.599 => 'Tertinggal',
            $skor < 0.707 => 'Berkembang',
            $skor < 0.815 => 'Maju',
            default       => 'Mandiri',
        };
    }

    public function statusColor(): string
    {
        return match($this->status) {
            'Sangat Tertinggal' => 'red',
            'Tertinggal'        => 'orange',
            'Berkembang'        => 'yellow',
            'Maju'              => 'blue',
            'Mandiri'           => 'green',
            default             => 'gray',
        };
    }
}
