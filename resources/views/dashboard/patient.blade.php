@extends('layouts.app')

@section('title', 'Dashboard Pasien')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0" style="color: var(--primary-color);">Dashboard Pasien</h1>
        <a href="{{ route('pasien.jadwal.index') }}" class="btn btn-warning shadow-sm">
            <i class="fas fa-calendar-check me-2"></i> Buat Janji Temu Baru
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card border-start-primary shadow-sm h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs fw-bold text-primary text-uppercase mb-1">
                                Janji Temu Aktif</div>
                            <div class="h5 mb-0 fw-bold text-dark">{{ $janjiTemuAktif ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card border-start-success shadow-sm h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs fw-bold text-success text-uppercase mb-1">
                                Total Konsultasi Selesai</div>
                            <div class="h5 mb-0 fw-bold text-dark">{{ $totalKonsultasi ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="content-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0" style="color: var(--primary-hover);">Riwayat Konsultasi Selesai</h5>
                    <div class="btn-group chart-filters" role="group">
                        <button type="button" class="btn btn-sm" data-range="today">Hari Ini</button>
                        <button type="button" class="btn btn-sm active" data-range="7days">7 Hari</button>
                        <button type="button" class="btn btn-sm" data-range="all">Semua</button>
                    </div>
                </div>
                <div>
                    <canvas id="dashboardChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <style>
        .border-start-primary { border-left: 5px solid var(--primary-color); } 
        .border-start-success { border-left: 5px solid var(--accent-green); }
        .text-gray-300 { color: #dddfeb; }
        .text-xs { font-size: 0.8rem; }
    </style>
@endsection

@push('page-scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('dashboardChart');
        if (!ctx) return;
        
        let chartInstance; 

        async function fetchChartData(range = '7days') {
            try {
                const response = await fetch(`{{ route('api.chart.data') }}?range=${range}`, {
                    headers: { 
                        'Accept': 'application/json', 
                        'X-Requested-With': 'XMLHttpRequest' 
                    }
                });
                
                if (!response.ok) throw new Error('Network response was not ok');
                
                const data = await response.json();
                
                if (chartInstance) chartInstance.destroy();
                
                chartInstance = new Chart(ctx, {
                    type: 'bar', 
                    data: {
                        labels: data.labels,
                        datasets: [{
                            label: 'Konsultasi Selesai',
                            data: data.data,
                            backgroundColor: 'rgba(255, 193, 7, 0.7)', 
                            borderColor: 'rgba(255, 193, 7, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: { 
                            y: { 
                                beginAtZero: true, 
                                ticks: { 
                                    precision: 0 
                                } 
                            } 
                        },
                        plugins: { 
                            legend: { 
                                display: false 
                            } 
                        }
                    }
                });
            } catch (error) { 
                console.error('Failed to fetch chart data:', error); 
                if(ctx.getContext('2d')) {
                    ctx.getContext('2d').fillText('Gagal memuat data grafik.', 10, 50);
                }
            }
        }

        document.querySelectorAll('.chart-filters .btn').forEach(button => {
            button.addEventListener('click', function() {
                document.querySelectorAll('.chart-filters .btn').forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
                fetchChartData(this.dataset.range);
            });
        });

        fetchChartData('7days');
    });
</script>
@endpush