<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Pengguna;

class Penanganan extends Model
{
    protected $table = 'penanganan';
    protected $primaryKey = 'penanganan_id';
    public $keyType = 'string';
    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'penanganan_id',
        'formulir_id',
        'teknisi_id',
        'status_penanganan',
        'catatan_progres',
        'deskripsi_hasil',
        'foto_progres_url',
        'foto_hasil_url',
        'tanggal_mulai',
        'tanggal_selesai',
        'updated_at',
    ];

    protected function casts(): array
    {
        return [
            'foto_progres_url' => 'array',
            'tanggal_mulai' => 'datetime',
            'tanggal_selesai' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    // ─── Status Constants (sesuai enum status_penanganan_enum) ──────────

    const STATUS_MULAI = 'mulai_dikerjakan';
    const STATUS_SELESAI = 'selesai';
    const STATUS_DITOLAK_ESKALASI = 'ditolak_eskalasi';

    // ─── Relations ─────────────────────────────────────────────────────────

    public function formulirLaporan()
    {
        return $this->belongsTo(FormulirLaporan::class, 'formulir_id', 'formulir_id');
    }

    public function teknisi()
    {
        return $this->belongsTo(Pengguna::class, 'teknisi_id', 'user_id');
    }

    // ─── Scopes ────────────────────────────────────────────────────────────

    public function scopeAktif($query)
    {
        return $query->where('status_penanganan', self::STATUS_MULAI);
    }

    public function scopeSelesai($query)
    {
        return $query->where('status_penanganan', self::STATUS_SELESAI);
    }

    // ─── Helpers ───────────────────────────────────────────────────────────

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status_penanganan) {
            self::STATUS_MULAI => 'Mulai Dikerjakan',
            self::STATUS_SELESAI => 'Selesai',
            default => ucfirst(str_replace('_', ' ', $this->status_penanganan ?? '')),
        };
    }

    protected static function booted()
    {
        static::updated(function (self $penanganan) {
            if ($penanganan->wasChanged('status_penanganan') && $penanganan->status_penanganan === self::STATUS_SELESAI) {
                Pengguna::where('user_id', $penanganan->teknisi_id)
                    ->update(['is_busy' => false]);
            }
        });
    }
}
