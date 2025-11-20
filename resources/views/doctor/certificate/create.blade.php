@extends('layouts.app')
@section('title', 'Buat Surat Keterangan')
@section('content')

<div class="content-card">
    <h4 class="mb-4" style="color: var(--primary-color);">Buat Surat Keterangan Medis</h4>
    
    <form action="{{ route('dokter.certificate.store', $appointment->id) }}" method="POST">
        @csrf
        
        <div class="mb-4">
            <label class="form-label">Pilih Jenis Surat</label>
            <select name="tipe_surat" id="tipe_surat" class="form-select" onchange="toggleForm()">
                <option value="Sehat">Surat Keterangan Sehat</option>
                <option value="Sakit">Surat Keterangan Sakit</option>
            </select>
        </div>

        <div id="form-sehat">
            <div class="row">
                <div class="col-md-6 mb-3"><label class="form-label">Tinggi Badan (cm)</label><input type="text" name="tinggi_badan" class="form-control"></div>
                <div class="col-md-6 mb-3"><label class="form-label">Berat Badan (kg)</label><input type="text" name="berat_badan" class="form-control"></div>
                <div class="col-md-6 mb-3"><label class="form-label">Tensi Darah (mmHg)</label><input type="text" name="tensi" class="form-control"></div>
                <div class="col-md-6 mb-3"><label class="form-label">Buta Warna</label>
                    <select name="buta_warna" class="form-select">
                        <option value="Tidak">Tidak Buta Warna</option>
                        <option value="Ya">Buta Warna</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3"><label class="form-label">Golongan Darah</label><input type="text" name="golongan_darah" class="form-control"></div>
            </div>
        </div>

        <div id="form-sakit" style="display: none;">
            <div class="mb-3"><label class="form-label">Jumlah Hari Istirahat</label><input type="number" name="jumlah_hari_istirahat" class="form-control"></div>
            <div class="row">
                <div class="col-md-6 mb-3"><label class="form-label">Mulai Tanggal</label><input type="date" name="mulai_tanggal" class="form-control"></div>
                <div class="col-md-6 mb-3"><label class="form-label">Sampai Tanggal</label><input type="date" name="sampai_tanggal" class="form-control"></div>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Catatan Tambahan (Opsional)</label>
            <textarea name="catatan_tambahan" class="form-control" rows="3"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Simpan & Buat Surat</button>
    </form>
</div>

<script>
    function toggleForm() {
        var tipe = document.getElementById('tipe_surat').value;
        if(tipe == 'Sehat') {
            document.getElementById('form-sehat').style.display = 'block';
            document.getElementById('form-sakit').style.display = 'none';
        } else {
            document.getElementById('form-sehat').style.display = 'none';
            document.getElementById('form-sakit').style.display = 'block';
        }
    }
</script>
@endsection