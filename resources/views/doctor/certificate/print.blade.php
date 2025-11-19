<!DOCTYPE html>
<html lang="id">
<head>
    <title>Surat Keterangan {{ $certificate->tipe_surat }}</title>
    <style>
        body { font-family: 'Times New Roman', serif; line-height: 1.6; padding: 40px; max-width: 800px; margin: auto; }
        .header { text-align: center; border-bottom: 3px double black; padding-bottom: 10px; margin-bottom: 30px; }
        .header h2 { margin: 0; }
        .content { margin-bottom: 50px; }
        .ttd { float: right; text-align: center; width: 200px; }
        @media print { .btn-print { display: none; } }
        .btn-print { display: block; width: 100%; padding: 10px; background: #0066cc; color: white; text-align: center; text-decoration: none; margin-top: 20px; border-radius: 5px; font-family: sans-serif;}
    </style>
</head>
<body>
    <div class="header">
        <h2>KLINIK PRATAMA UNIVERSITAS NEGERI MALANG</h2>
        <p>Jl. Semarang No. 5, Malang - Jawa Timur</p>
    </div>

    <h3 style="text-align: center; text-decoration: underline;">SURAT KETERANGAN {{ strtoupper($certificate->tipe_surat) }}</h3>

    <div class="content">
        <p>Yang bertanda tangan di bawah ini, Dokter Pemeriksa Klinik Pratama UM, menerangkan bahwa:</p>
        
        <table>
            <tr><td width="150">Nama</td><td>: <strong>{{ $certificate->appointment->patient->user->name }}</strong></td></tr>
            <tr><td>NIM/NIK</td><td>: {{ $certificate->appointment->patient->nim_nik }}</td></tr>
            <tr><td>Umur</td><td>: {{ \Carbon\Carbon::parse($certificate->appointment->patient->tgl_lahir)->age }} Tahun</td></tr>
            <tr><td>Alamat</td><td>: {{ $certificate->appointment->patient->alamat }}</td></tr>
        </table>

        <br>
        <p>Berdasarkan hasil pemeriksaan fisik yang dilakukan pada tanggal {{ $certificate->created_at->format('d F Y') }}, dengan hasil sebagai berikut:</p>

        @if($certificate->tipe_surat == 'Sehat')
            <ul>
                <li>Tinggi Badan: {{ $certificate->tinggi_badan }} cm</li>
                <li>Berat Badan: {{ $certificate->berat_badan }} kg</li>
                <li>Tekanan Darah: {{ $certificate->tensi }} mmHg</li>
                <li>Buta Warna: {{ $certificate->buta_warna }}</li>
                <li>Golongan Darah: {{ $certificate->golongan_darah ?? '-' }}</li>
            </ul>
            <p>Dinyatakan dalam keadaan <strong>SEHAT</strong>.</p>
        @else
            <p>Dinyatakan sedang <strong>SAKIT</strong> dan memerlukan istirahat selama <strong>{{ $certificate->jumlah_hari_istirahat }} hari</strong>, terhitung mulai tanggal {{ \Carbon\Carbon::parse($certificate->mulai_tanggal)->format('d-m-Y') }} sampai dengan {{ \Carbon\Carbon::parse($certificate->sampai_tanggal)->format('d-m-Y') }}.</p>
        @endif
        
        @if($certificate->catatan_tambahan)
            <p>Catatan: {{ $certificate->catatan_tambahan }}</p>
        @endif
    </div>

    <div class="ttd">
        <p>Malang, {{ date('d F Y') }}<br>Dokter Pemeriksa,</p>
        <br><br><br>
        <p><strong>{{ $certificate->appointment->schedule->doctor->user->name }}</strong><br>
        SIP: {{ $certificate->appointment->schedule->doctor->nip }}</p>
    </div>

    <div style="clear: both;"></div>
    <a href="#" onclick="window.print()" class="btn-print">Cetak Surat</a>
</body>
</html>