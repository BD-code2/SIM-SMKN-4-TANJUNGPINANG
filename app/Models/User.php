<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'avatar',
        'is_active',
        'nisn',
        'kelas',
        'program_keahlian',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    // Role helpers
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isKepalaSekolah(): bool
    {
        return $this->role === 'kepala_sekolah';
    }

    public function isTU(): bool
    {
        return $this->role === 'tu';
    }

    public function isHumas(): bool
    {
        return $this->role === 'humas';
    }

    public function isGuru(): bool
    {
        return $this->role === 'guru';
    }

    public function isSiswa(): bool
    {
        return $this->role === 'siswa';
    }

    public function hasRole(string|array $roles): bool
    {
        if (is_string($roles)) {
            $roles = [$roles];
        }
        return in_array($this->role, $roles);
    }

    public function getRoleLabelAttribute(): string
    {
        return match ($this->role) {
            'admin' => 'Administrator',
            'kepala_sekolah' => 'Kepala Sekolah',
            'tu' => 'Tata Usaha',
            'humas' => 'Humas',
            'guru' => 'Guru',
            'siswa' => 'Siswa',
            default => ucfirst($this->role ?? ''),
        };
    }

    // Relationships
    public function suratMasuks(): HasMany
    {
        return $this->hasMany(SuratMasuk::class, 'created_by');
    }

    public function suratKeluars(): HasMany
    {
        return $this->hasMany(SuratKeluar::class, 'created_by');
    }

    public function disposisiDiterima(): HasMany
    {
        return $this->hasMany(Disposisi::class, 'kepada_user_id');
    }

    public function disposisiDikirim(): HasMany
    {
        return $this->hasMany(Disposisi::class, 'dari_user_id');
    }

    public function agendas(): HasMany
    {
        return $this->hasMany(Agenda::class, 'created_by');
    }

    public function sertifikats(): HasMany
    {
        return $this->hasMany(SertifikatSiswa::class, 'siswa_user_id');
    }
}
