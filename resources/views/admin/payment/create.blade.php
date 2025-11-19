@extends('layouts.app')
@section('title', 'Input Pembayaran')
@section('content')

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="content-card">
            <h4 class="mb-3" style="color: var(--primary-color);">Input Pembayaran</h4>
            <p>Pasien: <strong>{{ $appointment->patient->user->name }}</strong> | NIM: {{ $appointment->patient->nim_nik }}</p>
            <hr>

            <form action="{{ route('admin.payment.store', $appointment->id) }}" method="POST">
                @csrf
                <div class="mb-3 row">
                    <label class="col-sm-4 col-form-label">Biaya Jasa Dokter (Rp)</label>
                    <div class="col-sm-8">
                        <input type="number" name="biaya_dokter" class="form-control" required value="50000">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-4 col-form-label">Biaya Tindakan (Rp)</label>
                    <div class="col-sm-8">
                        <input type="number" name="biaya_tindakan" class="form-control" required value="0">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-4 col-form-label">Biaya Obat (Rp)</label>
                    <div class="col-sm-8">
                        <input type="number" name="biaya_obat" class="form-control" required value="0">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-4 col-form-label">Metode Pembayaran</label>
                    <div class="col-sm-8">
                        <select name="metode_bayar" class="form-select">
                            <option value="Tunai">Tunai</option>
                            <option value="QRIS">QRIS</option>
                            <option value="Transfer">Transfer Bank</option>
                        </select>
                    </div>
                </div>
                
                <div class="text-end">
                    <button type="submit" class="btn btn-success btn-lg">
                        <i class="fas fa-save me-2"></i> Simpan & Lunas
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection