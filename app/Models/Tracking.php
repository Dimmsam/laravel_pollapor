<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tracking extends Model
{
    protected $table = 'tracking';
    protected $primaryKey = 'tracking_id';
    public $keyType = 'string';
    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'tracking_id',
        'formulir_id',
        'aktor_id',
        'jenis_event',
        'pesan_narasi',
        'metadata',
        'created_at',
    ];

    protected function casts(): array
    {
        return [
            'metadata' => 'array',
            'created_at' => 'datetime',
        ];
    }

    // ─── Event Constants (sesuai enum jenis_event_enum) ────────────────
    const EVENT_LAPORAN_DIBUAT = 'laporan_dibuat';
    const EVENT_LAPORAN_DITERIMA = 'laporan_diterima_admin';
    const EVENT_LAPORAN_DITOLAK = 'laporan_ditolak';
    const EVENT_TEKNISI_DITUGASKAN = 'teknisi_ditugaskan';
    const EVENT_TEKNISI_MULAI_PERIKSA = 'teknisi_mulai_periksa';
    const EVENT_PENANGANAN_DIMULAI = 'penanganan_dimulai';
    const EVENT_ESKALASI_DARI_TEKNISI = 'eskalasi_dari_teknisi';
    const EVENT_ESKALASI_DITOLAK = 'eskalasi_ditolak';
    const EVENT_ESKALASI_DISETUJUI = 'eskalasi_disetujui';
    const EVENT_KAJUR_APPROVE = 'kajur_approve_eskalasi';
    const EVENT_PENANGANAN_SELESAI = 'penanganan_selesai';
    const EVENT_DITERUSKAN_KE_PUSAT = 'diteruskan_ke_pusat';
    const EVENT_LAPORAN_DIKUNCI = 'laporan_dikunci';

    // ─── Relations ─────────────────────────────────────────────────────────

    public function formulirLaporan()
    {
        return $this->belongsTo(FormulirLaporan::class, 'formulir_id', 'formulir_id');
    }

    public function aktor()
    {
        return $this->belongsTo(Pengguna::class, 'aktor_id', 'user_id');
    }

    // ─── Helpers ───────────────────────────────────────────────────────────

    public function getEventLabelAttribute(): string
    {
        return match ($this->jenis_event) {
            self::EVENT_LAPORAN_DIBUAT => 'Laporan Dibuat',
            self::EVENT_LAPORAN_DITERIMA => 'Laporan Diterima Admin',
            self::EVENT_LAPORAN_DITOLAK => 'Laporan Ditolak',
            self::EVENT_TEKNISI_DITUGASKAN => 'Teknisi Ditugaskan',
            self::EVENT_TEKNISI_MULAI_PERIKSA => 'Teknisi Mulai Periksa',
            self::EVENT_PENANGANAN_DIMULAI => 'Penanganan Dimulai',
            self::EVENT_ESKALASI_DARI_TEKNISI => 'Eskalasi dari Teknisi',
            self::EVENT_ESKALASI_DITOLAK => 'Eskalasi Ditolak',
            self::EVENT_ESKALASI_DISETUJUI => 'Eskalasi Disetujui (Menunggu Kajur)',
            self::EVENT_KAJUR_APPROVE => 'Eskalasi Disetujui Kajur',
            self::EVENT_PENANGANAN_SELESAI => 'Penanganan Selesai',
            self::EVENT_DITERUSKAN_KE_PUSAT => 'Diteruskan ke Pusat',
            self::EVENT_LAPORAN_DIKUNCI => 'Laporan Dikunci',
            default => ucfirst(str_replace('_', ' ', $this->jenis_event ?? '')),
        };
    }
}
