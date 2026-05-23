<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Pengguna extends Authenticatable
{
    protected $table = 'pengguna';
    protected $primaryKey = 'user_id';
    public $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'email',
        'password',
        'role',
        'unit_jurusan',
        'is_busy',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'is_busy' => 'boolean',
            'password' => 'hashed',
        ];
    }

    // ─── Scopes ────────────────────────────────────────────────────────────

    public function scopeAdmin($query)
    {
        return $query->where('role', 'admin');
    }

    public function scopeKajur($query)
    {
        return $query->where('role', 'kajur');
    }

    public function scopeTeknisi($query)
    {
        return $query->where('role', 'teknisi');
    }

    public function scopeAvailable($query)
    {
        return $query->where('is_busy', false);
    }

    // ─── Relations ─────────────────────────────────────────────────────────

    public function laporanDibuat()
    {
        return $this->hasMany(FormulirLaporan::class, 'pelapor_id', 'user_id');
    }

    public function penanganan()
    {
        return $this->hasMany(Penanganan::class, 'teknisi_id', 'user_id');
    }

    // ─── Helpers ───────────────────────────────────────────────────────────

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isKajur(): bool
    {
        return $this->role === 'kajur';
    }

    public function isTeknisi(): bool
    {
        return $this->role === 'teknisi';
    }

    public function isAdminOrKajur(): bool
    {
        return in_array($this->role, ['admin', 'kajur']);
    }
}
