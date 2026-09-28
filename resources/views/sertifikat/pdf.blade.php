<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sertifikat PKL - {{ $sertifikat->nama_siswa }}</title>
    <style>
        @page { size: A4 landscape; margin: 0; }
        body { font-family: 'Times New Roman', Times, serif; color: #1a1a2e; margin: 0; padding: 0; }
        .bg { position: absolute; top: 0; left: 0; width: 842pt; height: 595pt; }
        .container { position: relative; padding: 40pt 62pt 28pt 62pt; text-align: center; }

        .judul { font-size: 42pt; font-weight: bold; letter-spacing: 2pt; color: #16213e; line-height: 1; }
        .nomor { font-size: 11.5pt; margin-top: 6pt; }
        .diberikan { font-size: 12.5pt; margin: 14pt 0 0 0; }
        .nama-siswa { font-size: 30pt; font-weight: bold; font-style: italic; letter-spacing: 1pt; margin: 8pt 0 12pt 0; }

        .data-siswa { margin: 0 auto; font-size: 12.5pt; }
        .data-siswa td { padding: 1.5pt 4pt; }
        .data-siswa .label { width: 175pt; text-align: left; }
        .data-siswa .titik { width: 16pt; text-align: center; }
        .data-siswa .nilai { text-align: left; font-weight: bold; }

        .deskripsi { font-size: 12.5pt; line-height: 1.55; width: 82%; margin: 16pt auto 0 auto; }

        .tabel-ttd { width: 100%; margin-top: 36pt; font-size: 11.5pt; }
        .tabel-ttd td { width: 50%; text-align: center; vertical-align: top; line-height: 1.45; }
        .ttd-instansi { font-weight: bold; text-decoration: underline; }
        .ttd-nama { font-weight: bold; text-decoration: underline; }
    </style>
</head>
<body>
@php
    $toB64 = function ($path) {
        return file_exists($path) ? 'data:image/png;base64,' . base64_encode(file_get_contents($path)) : '';
    };
    $bgImg     = $toB64(public_path('images/sertifikat-bg.png'));
    $logoKepri = $toB64(public_path('images/logo-kepri.png'));
    $logoSmkn4 = $toB64(public_path('images/logo-smkn4.png'));
@endphp

    <img class="bg" src="{{ $bgImg }}" alt="">

    <div class="container">
        <!-- Kepala Sertifikat: Logo Kepri - Judul - Logo SMKN4 -->
        <table width="100%" style="border-collapse: collapse;">
            <tr>
                <td width="110" align="left" valign="top">
                    @if($logoKepri)
                        <img src="{{ $logoKepri }}" style="height: 86pt;" alt="Logo Kepri">
                    @endif
                </td>
                <td align="center" valign="top">
                    <div class="judul">Sertifikat</div>
                    <div class="nomor">Nomor : {{ $sertifikat->no_sertifikat ?? 'B/423.4/P.06.209/I-SMKN4/PKL/' . date('Y') }}</div>
                </td>
                <td width="110" align="right" valign="top">
                    @if($logoSmkn4)
                        <img src="{{ $logoSmkn4 }}" style="height: 86pt;" alt="Logo SMKN4">
                    @endif
                </td>
            </tr>
        </table>

        <p class="diberikan">Diberikan Kepada</p>

        <div class="nama-siswa">{{ strtoupper($sertifikat->nama_siswa) }}</div>

        <table class="data-siswa" align="center" style="border-collapse: collapse;">
            <tr>
                <td class="label">Nomor Induk Siswa</td>
                <td class="titik">:</td>
                <td class="nilai">{{ $sertifikat->nisn }}</td>
            </tr>
            @if($sertifikat->tempat_lahir || $sertifikat->tanggal_lahir)
            <tr>
                <td class="label">Tempat / Tgl. Lahir</td>
                <td class="titik">:</td>
                <td class="nilai">
                    {{ $sertifikat->tempat_lahir ?? '' }}{{ $sertifikat->tempat_lahir && $sertifikat->tanggal_lahir ? ' / ' : '' }}{{ $sertifikat->tanggal_lahir ? $sertifikat->tanggal_lahir->locale('id')->translatedFormat('d F Y') : '' }}
                </td>
            </tr>
            @endif
            <tr>
                <td class="label">Konsentrasi Keahlian</td>
                <td class="titik">:</td>
                <td class="nilai">{{ $sertifikat->program_keahlian }}</td>
            </tr>
        </table>

        <p class="deskripsi">
            Telah selesai mengikuti Praktik Kerja Lapangan (PKL) pada<br>
            <strong>{{ strtoupper($sertifikat->industri->nama_industri ?? 'MITRA INDUSTRI') }}</strong>
            dengan Predikat <strong>{{ strtoupper($sertifikat->predikat ?? 'SANGAT BAIK') }}</strong>
        </p>

        <table class="tabel-ttd" style="border-collapse: collapse;">
            <tr>
                <td>
                    KEPALA<br>
                    <span class="ttd-instansi">SMK NEGERI 4 TANJUNGPINANG</span>
                    <br><br><br><br><br>
                    <span class="ttd-nama">Yayuk Sri Mulyani Rahayu, S.Pd., M.M.</span><br>
                    NIP 19770421 200502 2 011
                </td>
                <td>
                    KEPALA<br>
                    <span class="ttd-instansi">{{ strtoupper($sertifikat->industri->nama_industri ?? 'MITRA INDUSTRI') }}</span>
                    <br><br><br><br><br>
                    <span style="font-weight: bold;">( ................................................ )</span><br>
                    NIP .....................................
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
