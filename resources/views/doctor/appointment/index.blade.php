@extends('layouts.app')

@section('title', 'Pasien Saya')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0" style="color: var(--primary-color);">Antrean Pasien Hari Ini</h1>
</div>

{{-- Tampilkan Pesan Sukses/Error --}}
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

{{-- BAGIAN 1: DAFTAR ANTREAN (PASIEN MENUNGGU) --}}
<div class="row mb-5">
    @forelse($antreanHariIni as $item)
    <div class="col-md-6 mb-3">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Antrean No. {{ $item->nomor_antrean }}
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $item->patient->user->name }}</div>
                        <p class="mb-0 mt-2"><small class="text-muted"><i class="fas fa-comment-medical me-1"></i> Keluhan: {{ $item->keluhan }}</small></p>
                    </div>
                    <div class="col-auto">
                        {{-- Tombol Trigger Modal --}}
                        <button type="button" class="btn btn-success btn-sm shadow-sm" data-bs-toggle="modal" data-bs-target="#modalPeriksa{{ $item->id }}">
                            <i class="fas fa-stethoscope me-1"></i> Periksa & Selesai
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- MODAL INPUT PEMERIKSAAN & BIAYA --}}
        <div class="modal fade" id="modalPeriksa{{ $item->id }}" tabindex="-1" aria-labelledby="modalLabel{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="modalLabel{{ $item->id }}">Input Hasil Pemeriksaan & Biaya</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    
                    <form action="{{ route('dokter.appointment.process', $item->id) }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="alert alert-info py-2">
                                <i class="fas fa-user me-1"></i> Pasien: <strong>{{ $item->patient->user->name }}</strong> (Antrean No. {{ $item->nomor_antrean }})
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label fw-bold">Diagnosa / Catatan Medis</label>
                                <textarea name="diagnosa" class="form-control" rows="3" required placeholder="Tuliskan hasil diagnosa dan catatan pemeriksaan di sini..."></textarea>
                            </div>

                            <hr>
                            <h6 class="fw-bold text-primary mb-3"><i class="fas fa-file-invoice-dollar me-1"></i> Rincian Biaya (Kwitansi)</h6>
                            
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label small text-muted">Jasa Dokter (Rp)</label>
                                    <input type="number" name="biaya_dokter" class="form-control" value="50000" min="0" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small text-muted">Tindakan Medis (Rp)</label>
                                    <input type="number" name="biaya_tindakan" class="form-control" value="0" min="0" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small text-muted">Biaya Obat (Rp)</label>
                                    <input type="number" name="biaya_obat" class="form-control" value="0" min="0" required>
                                </div>
                            </div>

                            <div class="mt-4 p-3 bg-light rounded border">
                                <label class="form-label fw-bold text-dark">Metode Pembayaran Pasien</label>
                                <select name="metode_bayar" class="form-select" required>
                                    <option value="" disabled selected>-- Pilih Metode --</option>
                                    <option value="Tunai">Tunai (Bayar di Kasir/Admin)</option>
                                    <option value="QRIS">QRIS (Lunas Sekarang)</option>
                                </select>
                                <small class="text-muted d-block mt-2">
                                    <i class="fas fa-info-circle"></i> <strong>Catatan:</strong> 
                                    Jika pilih <u>Tunai</u>, status tagihan menjadi <strong>Belum Lunas</strong>. Pasien harus ke kasir agar Anda bisa mencetak surat/struk. 
                                    Jika <u>QRIS</u>, status langsung <strong>Lunas</strong>.
                                </small>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success"><i class="fas fa-save me-1"></i> Simpan & Selesaikan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="text-center py-5 text-muted bg-white rounded shadow-sm">
            <i class="fas fa-clipboard-check fa-3x mb-3 text-gray-300"></i>
            <p class="mb-0">Tidak ada pasien yang menunggu saat ini.</p>
        </div>
    </div>
    @endforelse
</div>

{{-- BAGIAN 2: RIWAYAT PEMERIKSAAN (TABEL UTAMA DENGAN LOGIKA PENGUNCIAN) --}}
<div class="content-card">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0 text-gray-800">Riwayat & Status Pembayaran Pasien</h5>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="bg-light">
                <tr>
                    <th>Tanggal</th>
                    <th>Pasien</th>
                    <th>Status Pembayaran</th>
                    <th style="width: 35%;">Aksi & Dokumen</th>
                </tr>
            </thead>
            <tbody>
                @foreach($riwayatPasien as $history)
                <tr>
                    <td>
                        <i class="far fa-clock me-1 text-muted"></i>
                        {{ $history->updated_at->format('d/m/Y H:i') }}
                    </td>
                    <td>
                        <span class="fw-bold text-dark">{{ $history->patient->user->name }}</span>
                        <br>
                        <small class="text-muted">{{ $history->patient->nim_nik }}</small>
                    </td>
                    <td>
                        @if($history->payment)
                            @if($history->payment->status == 'Lunas')
                                {{-- Status LUNAS --}}
                                <span class="badge bg-success px-3 py-2">
                                    <i class="fas fa-check-circle me-1"></i> LUNAS
                                </span>
                                <div class="small text-success mt-1 fw-bold">
                                    Dokumen Terbuka
                                </div>
                            @else
                                {{-- Status BELUM LUNAS --}}
                                <span class="badge bg-danger px-3 py-2">
                                    <i class="fas fa-times-circle me-1"></i> BELUM LUNAS
                                </span>
                                <div class="small text-danger mt-1 fw-bold">
                                    <i class="fas fa-arrow-right"></i> Arahkan ke Kasir!
                                </div>
                            @endif
                            
                            {{-- Tampilkan Total Tagihan --}}
                            <div class="small text-muted mt-1">
                                Tagihan: Rp {{ number_format($history->payment->total_bayar, 0, ',', '.') }}
                            </div>
                        @else
                            <span class="badge bg-secondary">Menunggu Input</span>
                        @endif
                    </td>
                    <td>
                        @if($history->payment && $history->payment->status == 'Lunas')
                            {{-- LOGIKA 1: JIKA LUNAS, TAMPILKAN TOMBOL --}}
                            <div class="d-flex gap-2">
                                {{-- Tombol Surat --}}
                                @if(!$history->medicalCertificate)
                                    <a href="{{ route('dokter.certificate.create', $history->id) }}" class="btn btn-sm btn-info text-white shadow-sm">
                                        <i class="fas fa-file-medical me-1"></i> Buat Surat
                                    </a>
                                @else
                                    <a href="{{ route('dokter.certificate.print', $history->medicalCertificate->id) }}" target="_blank" class="btn btn-sm btn-secondary shadow-sm">
                                        <i class="fas fa-print me-1"></i> Cetak Surat
                                    </a>
                                @endif
                                
                                {{-- Tombol Struk --}}
                                <a href="{{ route('dokter.payment.print', $history->payment->id) }}" target="_blank" class="btn btn-sm btn-outline-primary shadow-sm">
                                    <i class="fas fa-receipt me-1"></i> Struk
                                </a>
                            </div>

                        @elseif($history->payment && $history->payment->status == 'Belum Lunas')
                            {{-- LOGIKA 2: JIKA BELUM LUNAS, KUNCI TOMBOL --}}
                            <button class="btn btn-sm btn-light text-muted border" disabled title="Menunggu Pembayaran Lunas">
                                <i class="fas fa-lock me-1"></i> Dokumen Terkunci
                            </button>
                            
                        @else
                            {{-- LOGIKA 3: ERROR STATE --}}
                            <span class="text-muted small">-</span>
                        @endif
                    </td>
                </tr>
                @endforeach

                @if($riwayatPasien->isEmpty())
                <tr>
                    <td colspan="4" class="text-center py-4 text-muted">
                        Belum ada riwayat pemeriksaan selesai.
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
        
        {{-- Pagination --}}
        <div class="mt-3">
            {{ $riwayatPasien->links() }}
        </div>
    </div>
</div>
@endsection