<?php

namespace Database\Seeders;

use App\Models\Agenda;
use App\Models\Disposisi;
use App\Models\KerjaSamaIndustri;
use App\Models\SertifikatSiswa;
use App\Models\SuratKeluar;
use App\Models\SuratMasuk;
use App\Models\TemplateSertifikat;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ---------------------------------------------------------------------
        // 1. Akun Pengguna untuk Setiap Aktor SMKN 4 Tanjungpinang
        //    Password semua akun: password123
        // ---------------------------------------------------------------------
        $admin = User::updateOrCreate(
            ['email' => 'admin@smkn4tanjungpinang.sch.id'],
            [
                'name' => 'Administrator SIM',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'email_verified_at' => now(),
                'is_active' => true,
            ]
        );

        $kepsek = User::updateOrCreate(
            ['email' => 'kepsek@smkn4tanjungpinang.sch.id'],
            [
                'name' => 'Drs. H. Ahmad Dahlan, M.Pd.',
                'password' => Hash::make('password123'),
                'role' => 'kepala_sekolah',
                'email_verified_at' => now(),
                'is_active' => true,
            ]
        );

        $tu = User::updateOrCreate(
            ['email' => 'tu@smkn4tanjungpinang.sch.id'],
            [
                'name' => 'Rina Marlina, S.Kom.',
                'password' => Hash::make('password123'),
                'role' => 'tu',
                'email_verified_at' => now(),
                'is_active' => true,
            ]
        );

        $humas = User::updateOrCreate(
            ['email' => 'humas@smkn4tanjungpinang.sch.id'],
            [
                'name' => 'Bambang Haryanto, S.Pd.',
                'password' => Hash::make('password123'),
                'role' => 'humas',
                'email_verified_at' => now(),
                'is_active' => true,
            ]
        );

        $guru = User::updateOrCreate(
            ['email' => 'guru@smkn4tanjungpinang.sch.id'],
            [
                'name' => 'Siti Nurhaliza, S.Pd.',
                'password' => Hash::make('password123'),
                'role' => 'guru',
                'email_verified_at' => now(),
                'is_active' => true,
            ]
        );

        $siswa = User::updateOrCreate(
            ['email' => 'siswa@smkn4tanjungpinang.sch.id'],
            [
                'name' => 'Bayu Pratama',
                'password' => Hash::make('password123'),
                'role' => 'siswa',
                'nisn' => '0051234567',
                'kelas' => 'XII RPL 1',
                'program_keahlian' => 'Rekayasa Perangkat Lunak',
                'email_verified_at' => now(),
                'is_active' => true,
            ]
        );

        // ---------------------------------------------------------------------
        // 2. Data Awal Agenda (3 Agenda)
        // ---------------------------------------------------------------------
        Agenda::updateOrCreate(
            ['judul' => 'Rapat Koordinasi Guru'],
            [
                'deskripsi' => 'Rapat koordinasi bulanan dewan guru membahas evaluasi pembelajaran semester ganjil dan persiapan program kerja kurikulum merdeka.',
                'tanggal_mulai' => now()->toDateString(),
                'tanggal_selesai' => now()->toDateString(),
                'waktu' => '09:00:00',
                'lokasi' => 'Ruang Guru SMKN 4 Tanjungpinang',
                'tipe' => 'rapat',
                'is_penting' => true,
                'created_by' => $kepsek->id,
            ]
        );

        Agenda::updateOrCreate(
            ['judul' => 'Supervisi Kepala Sekolah'],
            [
                'deskripsi' => 'Pelaksanaan supervisi administrasi pembelajaran dan pemantauan kegiatan belajar mengajar di ruang kelas serta laboratorium kejuruan.',
                'tanggal_mulai' => now()->addDays(3)->toDateString(),
                'tanggal_selesai' => now()->addDays(5)->toDateString(),
                'waktu' => '08:00:00',
                'lokasi' => 'Ruang Kelas & Lab Komputer',
                'tipe' => 'kegiatan',
                'is_penting' => false,
                'created_by' => $kepsek->id,
            ]
        );

        Agenda::updateOrCreate(
            ['judul' => 'Ujian Sertifikasi PKL'],
            [
                'deskripsi' => 'Uji kompetensi, verifikasi portofolio, dan sidang laporan Praktik Kerja Lapangan (PKL) siswa kelas XII bersama tim penguji dari industri mitra.',
                'tanggal_mulai' => now()->addDays(10)->toDateString(),
                'tanggal_selesai' => now()->addDays(12)->toDateString(),
                'waktu' => '08:30:00',
                'lokasi' => 'Aula Utama & Lab RPL SMKN 4 Tanjungpinang',
                'tipe' => 'deadline',
                'is_penting' => true,
                'created_by' => $humas->id,
            ]
        );

        // ---------------------------------------------------------------------
        // 3. Data Awal Mitra Industri (3 Mitra Industri)
        // ---------------------------------------------------------------------
        $mitra1 = KerjaSamaIndustri::updateOrCreate(
            ['nama_industri' => 'PT. Teknologi Maju'],
            [
                'alamat' => 'Jl. D.I. Panjaitan Km. 9, Komplek Bintan Center, Tanjungpinang',
                'kontak' => '0812-7788-9900',
                'email' => 'hrd@teknologimaju.co.id',
                'program_keahlian' => 'Rekayasa Perangkat Lunak',
                'tanggal_mulai' => '2024-01-10',
                'tanggal_berakhir' => '2027-01-10',
                'status' => 'aktif',
                'catatan' => 'Kerja sama penyediaan tempat PKL, guru tamu, dan sertifikasi kompetensi kejuruan RPL.',
                'created_by' => $humas->id,
            ]
        );

        $mitra2 = KerjaSamaIndustri::updateOrCreate(
            ['nama_industri' => 'PT. Sinar Digital'],
            [
                'alamat' => 'Jl. Basuki Rahmat No. 45, Tanjungpinang',
                'kontak' => '0813-6655-4433',
                'email' => 'info@sinardigital.com',
                'program_keahlian' => 'Teknik Komputer dan Jaringan',
                'tanggal_mulai' => '2024-06-15',
                'tanggal_berakhir' => '2026-12-15',
                'status' => 'aktif',
                'catatan' => 'Kerja sama praktik kerja industri bidang jaringan komputer, cloud computing, dan fiber optik.',
                'created_by' => $humas->id,
            ]
        );

        $mitra3 = KerjaSamaIndustri::updateOrCreate(
            ['nama_industri' => 'CV. Maritim Jaya'],
            [
                'alamat' => 'Jl. Pelabuhan Sri Bintan Pura No. 12, Tanjungpinang',
                'kontak' => '0811-2233-4455',
                'email' => 'kontak@maritimjaya.id',
                'program_keahlian' => 'Nautika Kapal Niaga',
                'tanggal_mulai' => '2023-08-01',
                'tanggal_berakhir' => '2025-08-01',
                'status' => 'berakhir',
                'catatan' => 'Kerja sama magang industri maritim, logistik pelabuhan, dan penyerapan lulusan.',
                'created_by' => $humas->id,
            ]
        );

        // ---------------------------------------------------------------------
        // 4. Data Awal Surat Masuk (2 Surat Masuk) & Disposisi (1 Disposisi)
        // ---------------------------------------------------------------------
        $suratMasuk1 = SuratMasuk::updateOrCreate(
            ['no_agenda' => 'AGD/09/2026/0001'],
            [
                'no_surat' => '421/DISDIK-KEPRI/IX/2026/089',
                'tanggal_surat' => now()->subDays(4)->toDateString(),
                'tanggal_diterima' => now()->subDays(2)->toDateString(),
                'pengirim' => 'Dinas Pendidikan Provinsi Kepulauan Riau',
                'perihal' => 'Undangan Rapat Koordinasi Penyelenggaraan Uji Kompetensi Keahlian (UKK) SMK Se-Kepri',
                'isi_ringkas' => 'Rapat koordinasi teknis, verifikasi kelayakan Tempat Uji Kompetensi (TUK), dan sinkronisasi penguji industri untuk pelaksanaan UKK tahun ajaran berjalan.',
                'sifat' => 'segera',
                'status' => 'didisposisi',
                'created_by' => $tu->id,
            ]
        );

        // Disposisi dari Kepala Sekolah ke TU
        Disposisi::updateOrCreate(
            [
                'surat_masuk_id' => $suratMasuk1->id,
                'dari_user_id' => $kepsek->id,
                'kepada_user_id' => $tu->id,
            ],
            [
                'instruksi' => 'Tindak lanjuti dan siapkan berkas koordinasi serta konfirmasi kehadiran ke Dinas Pendidikan.',
                'catatan' => 'Koordinasikan dengan Waka Kurikulum dan siapkan data kelayakan TUK sebelum rapat berlangsung.',
                'status' => 'menunggu',
            ]
        );

        $suratMasuk2 = SuratMasuk::updateOrCreate(
            ['no_agenda' => 'AGD/09/2026/0002'],
            [
                'no_surat' => '045/B/PT-TM/VIII/2026',
                'tanggal_surat' => now()->subDays(6)->toDateString(),
                'tanggal_diterima' => now()->subDays(3)->toDateString(),
                'pengirim' => 'PT. Teknologi Maju',
                'perihal' => 'Konfirmasi Penerimaan Siswa Praktik Kerja Lapangan (PKL) Periode Ganjil',
                'isi_ringkas' => 'Pemberitahuan bahwa PT. Teknologi Maju siap menerima 10 siswa kompetensi keahlian Rekayasa Perangkat Lunak untuk melaksanakan PKL selama 6 bulan.',
                'sifat' => 'biasa',
                'status' => 'diterima',
                'created_by' => $tu->id,
            ]
        );

        // ---------------------------------------------------------------------
        // 5. Data Awal Surat Keluar (1 Surat Keluar)
        // ---------------------------------------------------------------------
        SuratKeluar::updateOrCreate(
            ['no_surat' => 'SK/09/2026/0001'],
            [
                'tanggal_surat' => now()->toDateString(),
                'tujuan' => 'Kepala Dinas Pendidikan Provinsi Kepulauan Riau',
                'perihal' => 'Konfirmasi Kehadiran Rapat Koordinasi UKK SMK 2026',
                'isi_ringkas' => 'Menyampaikan kesediaan hadir Kepala Sekolah dan Waka Kurikulum dalam Rapat Koordinasi UKK SMK se-Provinsi Kepulauan Riau.',
                'sifat' => 'biasa',
                'referensi_surat_masuk_id' => $suratMasuk1->id,
                'status' => 'disetujui',
                'created_by' => $tu->id,
                'approved_by' => $kepsek->id,
                'approved_at' => now(),
            ]
        );

        // ---------------------------------------------------------------------
        // 6. Template Sertifikat & Data Sertifikat Siswa PKL (2 Sertifikat)
        // ---------------------------------------------------------------------
        $template = TemplateSertifikat::firstOrCreate(
            ['nama' => 'Template Sertifikat PKL Standar SMKN 4'],
            [
                'deskripsi' => 'Format resmi sertifikat Praktik Kerja Lapangan SMKN 4 Tanjungpinang',
                'file_path' => null,
                'is_active' => true,
            ]
        );

        // Sertifikat 1: Diterbitkan
        SertifikatSiswa::updateOrCreate(
            ['no_sertifikat' => 'SERT/2026/0001'],
            [
                'siswa_user_id' => $siswa->id,
                'nama_siswa' => $siswa->name,
                'nisn' => $siswa->nisn,
                'kelas' => $siswa->kelas,
                'program_keahlian' => $siswa->program_keahlian,
                'kerja_sama_industri_id' => $mitra1->id,
                'tanggal_mulai_pkl' => '2026-01-05',
                'tanggal_selesai_pkl' => '2026-06-30',
                'nilai' => 92.50,
                'predikat' => 'Sangat Baik',
                'template_id' => $template->id,
                'status' => 'diterbitkan',
                'diterbitkan_oleh' => $kepsek->id,
                'diterbitkan_pada' => now()->subDays(10),
            ]
        );

        // Sertifikat 2: Terverifikasi (siap diterbitkan oleh Kepala Sekolah)
        SertifikatSiswa::updateOrCreate(
            ['no_sertifikat' => 'SERT/2026/0002'],
            [
                'siswa_user_id' => $siswa->id,
                'nama_siswa' => $siswa->name,
                'nisn' => $siswa->nisn,
                'kelas' => $siswa->kelas,
                'program_keahlian' => $siswa->program_keahlian,
                'kerja_sama_industri_id' => $mitra2->id,
                'tanggal_mulai_pkl' => '2026-07-01',
                'tanggal_selesai_pkl' => '2026-09-01',
                'nilai' => 88.00,
                'predikat' => 'Baik',
                'template_id' => $template->id,
                'status' => 'terverifikasi',
                'diterbitkan_oleh' => null,
                'diterbitkan_pada' => null,
            ]
        );
    }
}
