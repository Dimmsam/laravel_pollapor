<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormulirLaporan extends Model
{
    protected $table = 'formulir_laporan';
    protected $primaryKey = 'formulir_id';
    public $keyType = 'string';
    public $incrementing = false;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'formulir_id',
        'pelapor_id',
        'nomor_surat',
        'tanggal_masuk',
        'tanggal_selesai',
        'prioritas',
        'nama_sarana',
        'keterangan_kerusakan',
        'lokasi_id',
        'nomor_inventaris',
        'foto_kerusakan_url',
        'status',
        'is_synced',
        'is_locked',
    ];

    protected function casts(): array
    {
        return [
            'is_synced' => 'boolean',
            'is_locked' => 'boolean',
            'tanggal_masuk' => 'date',
            'tanggal_selesai' => 'date',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    // ─── Status Constants (sesuai enum status_formulir di Supabase) ────────

    const STATUS_MENUNGGU = 'menunggu';
    const STATUS_DITUGASKAN = 'ditugaskan';
    const STATUS_SEDANG_DIKERJAKAN = 'sedang_dikerjakan';
    const STATUS_SELESAI = 'selesai';
    const STATUS_DITERUSKAN_KE_PUSAT = 'diteruskan_ke_pusat';

    // ─── Scopes ────────────────────────────────────────────────────────────

    public function scopeMenunggu($query)
    {
        return $query->where('status', self::STATUS_MENUNGGU);
    }

    public function scopeDitugaskan($query)
    {
        return $query->where('status', self::STATUS_DITUGASKAN);
    }

    public function scopeSedangDikerjakan($query)
    {
        return $query->where('status', self::STATUS_SEDANG_DIKERJAKAN);
    }

    public function scopeSelesai($query)
    {
        return $query->where('status', self::STATUS_SELESAI);
    }

    public function scopeDiteruskanKePusat($query)
    {
        return $query->where('status', self::STATUS_DITERUSKAN_KE_PUSAT);
    }

    public function scopeBelumDitangani($query)
    {
        return $query->where('status', self::STATUS_MENUNGGU);
    }

    public function scopeSiapBeritaAcara($query)
    {
        return $query->whereIn('status', [self::STATUS_SELESAI, self::STATUS_DITERUSKAN_KE_PUSAT]);
    }

    // ─── Relations ─────────────────────────────────────────────────────────

    public function pelapor()
    {
        return $this->belongsTo(Pengguna::class, 'pelapor_id', 'user_id');
    }

    public function penangananList()
    {
        return $this->hasMany(Penanganan::class, 'formulir_id', 'formulir_id');
    }

    public function penanganan()
    {
        return $this->hasOne(Penanganan::class, 'formulir_id', 'formulir_id')->latest('updated_at');
    }

    public function trackings()
    {
        return $this->hasMany(Tracking::class, 'formulir_id', 'formulir_id')
            ->orderBy('created_at', 'asc');
    }

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class, 'lokasi_id', 'lokasi_id');
    }

    // ─── Helpers ───────────────────────────────────────────────────────────

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_MENUNGGU => 'Menunggu',
            self::STATUS_DITUGASKAN => 'Ditugaskan',
            self::STATUS_SEDANG_DIKERJAKAN => 'Sedang Dikerjakan',
            self::STATUS_SELESAI => 'Selesai',
            self::STATUS_DITERUSKAN_KE_PUSAT => 'Diteruskan ke Pusat',
            default => ucfirst(str_replace('_', ' ', $this->status ?? '')),
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_MENUNGGU => 'yellow',
            self::STATUS_DITUGASKAN => 'blue',
            self::STATUS_SEDANG_DIKERJAKAN => 'orange',
            self::STATUS_SELESAI => 'green',
            self::STATUS_DITERUSKAN_KE_PUSAT => 'red',
            default => 'gray',
        };
    }
}
