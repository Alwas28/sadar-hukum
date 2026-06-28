<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StrukturDesa extends Model
{
    protected $table      = 'struktur_desa';
    protected $primaryKey = 'jabatan';
    protected $keyType    = 'string';
    public    $incrementing = false;

    protected $fillable = ['jabatan', 'nama', 'foto'];

    public static function positions(): array
    {
        return ['kepala_desa', 'sekretaris', 'bendahara', 'ketua_bpd'];
    }

    public static function label(string $jabatan): string
    {
        return match($jabatan) {
            'kepala_desa' => 'Kepala Desa',
            'sekretaris'  => 'Sekretaris Desa',
            'bendahara'   => 'Bendahara Desa',
            'ketua_bpd'   => 'Ketua BPD',
            default       => $jabatan,
        };
    }

    public static function initials(string $jabatan): string
    {
        return match($jabatan) {
            'kepala_desa' => 'KD',
            'sekretaris'  => 'SD',
            'bendahara'   => 'BD',
            'ketua_bpd'   => 'BP',
            default       => '??',
        };
    }

    public static function color(string $jabatan): string
    {
        return match($jabatan) {
            'kepala_desa' => 'primary',
            'sekretaris'  => 'blue',
            'bendahara'   => 'amber',
            'ketua_bpd'   => 'purple',
            default       => 'gray',
        };
    }
}
