<!DOCTYPE html>
<html lang="id">
<head>
    <title>Invoice #{{ $payment->id }}</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        .invoice-box { max-width: 800px; margin: auto; padding: 30px; border: 1px solid #eee; box-shadow: 0 0 10px rgba(0, 0, 0, 0.15); }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; color: #003366; }
        table { width: 100%; line-height: inherit; text-align: left; border-collapse: collapse; }
        table td { padding: 5px; vertical-align: top; }
        table tr.total td:nth-child(2) { border-top: 2px solid #eee; font-weight: bold; }
        .btn-print { display: block; width: 100%; padding: 10px; background: #0066cc; color: white; text-align: center; text-decoration: none; margin-top: 20px; border-radius: 5px;}
        @media print { .btn-print { display: none; } }
    </style>
</head>
<body>
    <div class="invoice-box">
        <div class="header">
            <h1>KLINIK PRATAMA UM</h1>
            <p>Jl. Semarang No. 5, Malang</p>
        </div>

        <table>
            <tr>
                <td>
                    No. Kwitansi: #{{ $payment->id }}<br>
                    Tanggal: {{ $payment->created_at->format('d/m/Y') }}<br>
                    Metode: {{ $payment->metode_bayar }}
                </td>
                <td style="text-align: right;">
                    Pasien: <strong>{{ $payment->appointment->patient->user->name }}</strong><br>
                    Dokter: {{ $payment->appointment->schedule->doctor->user->name }}
                </td>
            </tr>
        </table>
        <br>
        <table border="1" cellpadding="10">
            <tr style="background: #eee;">
                <th>Keterangan</th>
                <th style="text-align: right;">Jumlah (Rp)</th>
            </tr>
            <tr>
                <td>Jasa Dokter</td>
                <td style="text-align: right;">{{ number_format($payment->biaya_dokter, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Tindakan Medis</td>
                <td style="text-align: right;">{{ number_format($payment->biaya_tindakan, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Biaya Obat</td>
                <td style="text-align: right;">{{ number_format($payment->biaya_obat, 0, ',', '.') }}</td>
            </tr>
            <tr class="total">
                <td style="text-align: right;"><strong>TOTAL BAYAR</strong></td>
                <td style="text-align: right; font-size: 18px;"><strong>Rp {{ number_format($payment->total_bayar, 0, ',', '.') }}</strong></td>
            </tr>
        </table>
        
        <br>
        <p style="text-align: center; font-size: 12px;">Terima kasih atas kunjungan Anda. Semoga lekas sembuh.</p>

        <a href="#" onclick="window.print()" class="btn-print">Cetak Kwitansi</a>
    </div>
</body>
</html>