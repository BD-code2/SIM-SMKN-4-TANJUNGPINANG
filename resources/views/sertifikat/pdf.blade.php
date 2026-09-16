<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sertifikat PKL - {{ $sertifikat->nama_siswa }}</title>
    <style>
        @page { size: A4 landscape; margin: 20px; }
        body { font-family: 'Times New Roman', Times, serif; color: #1e293b; margin: 0; padding: 25px; text-align: center; }
        .border-outer { border: 6px double #0A4DBA; padding: 25px; height: 90%; box-sizing: border-box; }
        .border-inner { border: 1.5px solid #0A4DBA; padding: 30px; height: 85%; }
        .kop h2 { margin: 0; font-size: 16pt; font-weight: bold; text-transform: uppercase; color: #0A4DBA; }
        .kop h1 { margin: 5px 0; font-size: 24pt; font-weight: bold; text-transform: uppercase; letter-spacing: 2px; }
        .kop p { margin: 0; font-size: 11pt; color: #64748b; }
        .no-sertifikat { font-size: 11pt; margin-top: 15px; font-weight: bold; }
        .recipient { margin: 25px 0 15px 0; }
        .recipient .name { font-size: 26pt; font-weight: bold; color: #0A4DBA; text-decoration: underline; }
        .recipient .meta { font-size: 13pt; margin-top: 8px; }
        .description { font-size: 12pt; line-height: 1.6; max-width: 80%; margin: 0 auto 20px auto; }
        .table-ttd { width: 100%; margin-top: 30px; }
        .table-ttd td { text-align: center; width: 50%; vertical-align: top; font-size: 11pt; }
    </style>
</head>
<body>
    <div class="border-outer">
        <div class="border-inner">
            <div class="kop">
                <h2>Pemerintah Provinsi Kepulauan Riau &bull; Dinas Pendidikan</h2>
                <h1>SMK Negeri 4 Tanjungpinang</h1>
                <p>SERTIFIKAT PRAKTIK KERJA LAPANGAN (PKL)</p>
            </div>

            <div class="no-sertifikat">
                Nomor: {{ $sertifikat->no_sertifikat ?? 'SERT/PKL/SMKN4/2026' }}
            </div>

            <p style="margin-top: 20px; font-size: 12pt;">Diberikan kepada:</p>

            <div class="recipient">
                <div class="name">{{ $sertifikat->nama_siswa }}</div>
                <div class="meta">NISN: <strong>{{ $sertifikat->nisn }}</strong> &bull; Kelas: <strong>{{ $sertifikat->kelas }}</strong> &bull; Kompetensi: <strong>{{ $sertifikat->program_keahlian }}</strong></div>
            </div>

            <div class="description">
                Telah melaksanakan kegiatan <strong>Praktik Kerja Lapangan (PKL)</strong> pada <strong>{{ $sertifikat->industri->nama_industri ?? 'Mitra Industri' }}</strong> dari tanggal <strong>{{ $sertifikat->tanggal_mulai_pkl->format('d F Y') }}</strong> sampai dengan <strong>{{ $sertifikat->tanggal_selesai_pkl->format('d F Y') }}</strong> dengan perolehan Nilai: <strong>{{ $sertifikat->nilai ?? '90' }} ({{ $sertifikat->predikat ?? 'Sangat Baik' }})</strong>.
            </div>

            <table class="table-ttd">
                <tr>
                    <td>
                        Pimpinan Industri Mitra,<br>
                        <strong>{{ $sertifikat->industri->nama_industri ?? 'Mitra DUDI' }}</strong>
                        <br><br><br><br>
                        (......................................................)
                    </td>
                    <td>
                        Tanjungpinang, {{ $sertifikat->diterbitkan_pada ? $sertifikat->diterbitkan_pada->format('d F Y') : date('d F Y') }}<br>
                        Kepala SMK Negeri 4 Tanjungpinang,
                        <br><br><br><br>
                        <strong style="text-decoration: underline;">{{ $sertifikat->penerbit->name ?? 'Drs. H. Ahmad Dahlan, M.Pd.' }}</strong><br>
                        NIP. 19681231 199403 1 008
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>
