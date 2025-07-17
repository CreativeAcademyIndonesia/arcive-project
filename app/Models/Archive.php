<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archive extends Model
{
    use HasFactory;

    // Nama tabel (opsional, jika nama tabel tidak jamak dari model)
    protected $table = 'archives';

    // Kolom yang boleh diisi secara massal
    protected $fillable = [
    'nomor_akta',
    'nama_klien',
    'jenis_dokumen',
    'tanggal_akta',
    'kategori_id',
    'lampiran',
];

 public function category()
    {
        return $this->belongsTo(Category::class, 'kategori_id');
    }
}
