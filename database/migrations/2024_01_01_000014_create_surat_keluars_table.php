<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('surat_keluars', function (Blueprint $table) {
            $table->id();
            $table->string('no_surat')->unique()->nullable();
            $table->date('tanggal_surat');
            $table->string('tujuan');
            $table->string('perihal');
            $table->text('isi_ringkas')->nullable();
            $table->enum('sifat', ['biasa', 'segera', 'rahasia'])->default('biasa');
            $table->string('lampiran_path')->nullable();
            $table->foreignId('referensi_surat_masuk_id')->nullable()->constrained('surat_masuks')->nullOnDelete();
            $table->enum('status', [
                'draft',
                'menunggu_persetujuan',
                'disetujui',
                'ditolak',
                'dikirim',
                'diarsipkan'
            ])->default('draft');
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->text('catatan_revisi')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_keluars');
    }
};
