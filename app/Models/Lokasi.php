<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lokasi extends Model
{
    protected $table = 'lokasi';
    protected $primaryKey = 'lokasi_id';
    public $keyType = 'string';
    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'lokasi_id',
        'nama_ruangan',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    // ─── Relations ─────────────────────────────────────────────────────────

    public function formulirLaporan()
    {
        return $this->hasMany(FormulirLaporan::class, 'lokasi_id', 'lokasi_id');
    }

    // ─── Scopes ────────────────────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
