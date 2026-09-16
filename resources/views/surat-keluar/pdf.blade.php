<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat Keluar - {{ $suratKeluar->no_surat }}</title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; font-size: 12pt; line-height: 1.5; margin: 30px; color: #111; }
        .kop { text-align: center; border-bottom: 3px double #000; padding-bottom: 10px; margin-bottom: 25px; }
        .kop h2 { margin: 0; font-size: 14pt; text-transform: uppercase; font-weight: bold; }
        .kop h1 { margin: 2px 0; font-size: 16pt; text-transform: uppercase; font-weight: bold; }
        .kop p { margin: 0; font-size: 10pt; }
        .table-meta { width: 100%; margin-bottom: 20px; }
        .table-meta td { vertical-align: top; padding: 2px 0; }
        .content { text-align: justify; margin-top: 15px; margin-bottom: 35px; }
        .ttd { float: right; width: 260px; text-align: center; margin-top: 30px; }
    </style>
</head>
<body>
    <div class="kop">
        <h2>Pemerintah Provinsi Kepulauan Riau</h2>
        <h2>Dinas Pendidikan</h2>
        <h1>SMK Negeri 4 Tanjungpinang</h1>
        <p>Jl. Nusantara Km. 14 Tanjungpinang, Kepulauan Riau</p>
        <p>Telepon: (0771) 123456 | Website: smkn4tanjungpinang.sch.id | Email: info@smkn4tanjungpinang.sch.id</p>
    </div>

    <table class="table-meta">
        <tr>
            <td style="width: 80px;">Nomor</td>
            <td style="width: 10px;">:</td>
            <td style="width: 350px;"><strong>{{ $suratKeluar->no_surat ?? '-' }}</strong></td>
            <td style="text-align: right;">Tanjungpinang, {{ $suratKeluar->tanggal_surat->format('d F Y') }}</td>
        </tr>
        <tr>
            <td>Sifat</td>
            <td>:</td>
            <td colspan="2">{{ ucfirst($suratKeluar->sifat) }}</td>
        </tr>
        <tr>
            <td>Lampiran</td>
            <td>:</td>
            <td colspan="2">{{ $suratKeluar->lampiran_path ? '1 (Satu) Berkas' : '-' }}</td>
        </tr>
        <tr>
            <td>Perihal</td>
            <td>:</td>
            <td colspan="2"><strong>{{ $suratKeluar->perihal }}</strong></td>
        </tr>
    </table>

    <div style="margin-bottom: 20px;">
        <p>Kepada Yth.<br>
        <strong>{{ $suratKeluar->tujuan }}</strong><br>
        Di Tempat</p>
    </div>

    <div class="content">
        <p>Dengan hormat,</p>
        <p>{{ $suratKeluar->isi_ringkas ?? 'Sehubungan dengan program pendidikan vokasi dan keterpaduan kerja sama industri di SMK Negeri 4 Tanjungpinang, bersama surat ini kami sampaikan hal terkait perihal di atas.' }}</p>
        <p>Demikian surat ini kami sampaikan, atas perhatian dan kerja sama yang baik kami ucapkan terima kasih.</p>
    </div>

    <div class="ttd">
        <p>Kepala SMK Negeri 4 Tanjungpinang,</p>
        <br><br><br><br>
        <p style="text-decoration: underline; font-weight: bold;">
            {{ $suratKeluar->approver->name ?? 'Drs. H. Ahmad Dahlan, M.Pd.' }}
        </p>
        <p>NIP. 19681231 199403 1 008</p>
    </div>
</body>
</html>
