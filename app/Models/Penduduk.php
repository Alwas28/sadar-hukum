<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penduduk extends Model
{
    protected $table = 'penduduks';

    protected $fillable = [
        'nik', 'nama', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir',
        'alamat', 'rt', 'rw', 'agama', 'status_perkawinan',
        'pekerjaan', 'pendidikan', 'aktif',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'aktif'         => 'boolean',
    ];

    public function umur(): int
    {
        return $this->tanggal_lahir->age;
    }

    public static function agamaOptions(): array
    {
        return ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'];
    }

    public static function statusPerkawinanOptions(): array
    {
        return ['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati'];
    }

    public static function pendidikanOptions(): array
    {
        return ['Tidak/Belum Sekolah', 'SD/Sederajat', 'SMP/Sederajat', 'SMA/Sederajat', 'D1/D2/D3', 'S1/D4', 'S2', 'S3'];
    }

    public static function pekerjaanOptions(): array
    {
        return [
            'Tidak/Belum Bekerja',
            'Pelajar/Mahasiswa',
            'Ibu Rumah Tangga',
            'Petani/Pekebun',
            'Nelayan/Perikanan',
            'Buruh Tani',
            'Buruh/Karyawan Swasta',
            'Wiraswasta/Pedagang',
            'PNS/ASN',
            'TNI',
            'POLRI',
            'Pegawai BUMN/BUMD',
            'Guru/Tenaga Pendidik',
            'Tenaga Kesehatan',
            'Pengacara/Konsultan',
            'Pensiunan',
            'Lainnya',
        ];
    }
}
