<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class SuratKeluar extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'surat_keluars';

    protected $fillable = [
        'no_surat',
        'tanggal_surat',
        'tujuan',
        'perihal',
        'isi_ringkas',
        'sifat',
        'lampiran_path',
        'referensi_surat_masuk_id',
        'status',
        'created_by',
        'approved_by',
        'approved_at',
        'catatan_revisi',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_surat' => 'date',
            'approved_at' => 'datetime',
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function (SuratKeluar $model) {
            if ($model->status === 'disetujui' && empty($model->no_surat)) {
                $month = now()->format('m');
                $year = now()->format('Y');
                $prefix = "SK/{$month}/{$year}/";

                $latest = static::withTrashed()
                    ->where('no_surat', 'LIKE', $prefix . '%')
                    ->orderByDesc('id')
                    ->first();

                $seq = 1;
                if ($latest && preg_match('/\/(\d+)$/', $latest->no_surat, $matches)) {
                    $seq = intval($matches[1]) + 1;
                }

                $model->no_surat = sprintf('SK/%s/%s/%04d', $month, $year, $seq);

                if (empty($model->approved_at)) {
                    $model->approved_at = now();
                }
            }
        });
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function referensiSuratMasuk(): BelongsTo
    {
        return $this->belongsTo(SuratMasuk::class, 'referensi_surat_masuk_id');
    }

    public function suratMasuk(): BelongsTo
    {
        return $this->belongsTo(SuratMasuk::class, 'referensi_surat_masuk_id');
    }
}
