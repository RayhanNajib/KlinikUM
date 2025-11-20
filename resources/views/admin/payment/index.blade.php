@extends('layouts.app')

@section('title', 'Kasir & Laporan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0" style="color: var(--primary-color);">Kasir & Laporan Pembayaran</h1>
</div>

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<div class="content-card">
    <div class="table-responsive">
        <table class="table table-custom table-hover">
            <thead>
                <tr>
                    <th>No. Kwitansi</th>
                    <th>Pasien</th>
                    <th>Metode</th>
                    <th>Total Tagihan</th>
                    <th>Status</th>
                    <th>Aksi (Kasir)</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $pay)
                <tr>
                    <td>#{{ $pay->id }}</td>
                    <td>
                        <span class="fw-bold">{{ $pay->appointment->patient->user->name }}</span><br>
                        <small class="text-muted">{{ $pay->created_at->format('d M Y H:i') }}</small>
                    </td>
                    <td>{{ $pay->metode_bayar }}</td>
                    <td class="fw-bold text-primary">Rp {{ number_format($pay->total_bayar, 0, ',', '.') }}</td>
                    <td>
                        @if($pay->status == 'Lunas')
                            <span class="badge bg-success">LUNAS</span>
                        @else
                            <span class="badge bg-danger">BELUM LUNAS</span>
                        @endif
                    </td>
                    <td>
                        @if($pay->status == 'Belum Lunas')
                            <form action="{{ route('admin.payment.lunas', $pay->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda sudah menerima uang tunai dari pasien ini?');">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-success shadow-sm">
                                    <i class="fas fa-money-bill-wave me-1"></i> Terima Bayar
                                </button>
                            </form>
                        @else
                            <button class="btn btn-sm btn-secondary" disabled><i class="fas fa-check"></i> Selesai</button>
                            <a href="{{ route('admin.payment.show', $pay->id) }}" target="_blank" class="btn btn-sm btn-outline-primary ms-1">
                                <i class="fas fa-print"></i>
                            </a>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center py-4">Belum ada data transaksi.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection