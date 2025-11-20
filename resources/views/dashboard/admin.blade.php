@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0" style="color: var(--primary-color);">Dashboard Admin</h1>
        <a href="{{ route('admin.jadwal.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-calendar-plus me-2"></i> Buat Jadwal Baru
        </a>
    </div>

    <div class="row">

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start-primary shadow-sm h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs fw-bold text-primary text-uppercase mb-1">
                                Total Dokter</div>
                            <div class="h5 mb-0 fw-bold text-dark">{{ $totalDoctors ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-doctor fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start-success shadow-sm h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs fw-bold text-success text-uppercase mb-1">
                                Total Pasien (Mahasiswa)</div>
                            <div class="h5 mb-0 fw-bold text-dark">{{ $totalPatients ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-injured fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start-info shadow-sm h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs fw-bold text-info text-uppercase mb-1">
                                Janji Temu (Hari Ini)</div>
                            <div class="h5 mb-0 fw-bold text-dark">{{ $appointmentsToday ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-day fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-start-warning shadow-sm h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs fw-bold text-warning text-uppercase mb-1">
                                Jadwal Tersedia (Total)</div>
                            <div class="h5 mb-0 fw-bold text-dark">{{ $schedulesAvailable ?? 0 }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
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
                    <h5 class="mb-0" style="color: var(--primary-hover);">Aktivitas Klinik (Konsultasi Selesai)</h5>
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
        .border-start-info { border-left: 5px solid #17a2b8; }
        .border-start-warning { border-left: 5px solid var(--accent-gold); }
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
                        'X-Requested-With': 'XMLHttpRequest',
                    }
                });
                if (!response.ok) throw new Error('Network response was not ok');
                
                const data = await response.json();

                if (chartInstance) {
                    chartInstance.destroy();
                }

                chartInstance = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            label: 'Konsultasi Selesai',
                            data: data.data,
                            fill: true,
                            backgroundColor: 'rgba(0, 102, 204, 0.1)',
                            borderColor: 'rgba(0, 102, 204, 1)',
                            tension: 0.3
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