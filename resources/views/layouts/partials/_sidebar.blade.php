<nav id="sidebar-wrapper">
    <div class="sidebar-heading">
        <i class="fas fa-clinic-medical me-2"></i> Klinik UM
    </div>

    <div class="list-group list-group-flush">
        
        @if(Auth::user()->role == 'admin')
            
            <a href="{{ route('dashboard') }}" class="list-group-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fas fa-fw fa-chart-line"></i> Dashboard
            </a>
            <a href="{{ route('admin.dokter.index') }}" class="list-group-item {{ request()->routeIs('admin.dokter.*') ? 'active' : '' }}">
                <i class="fas fa-fw fa-user-doctor"></i> Kelola Dokter
            </a>
            
            <a href="{{ route('admin.pasien.index') }}" class="list-group-item {{ request()->routeIs('admin.pasien.*') ? 'active' : '' }}"> 
                <i class="fas fa-fw fa-user-injured"></i> Kelola Pasien
            </a>
            
            <a href="{{ route('admin.jadwal.index') }}" class="list-group-item {{ request()->routeIs('admin.jadwal.*') ? 'active' : '' }}">
                <i class="fas fa-fw fa-calendar-alt"></i> Kelola Jadwal
            </a>

        @elseif(Auth::user()->role == 'doctor')
            
            <a href="{{ route('dashboard') }}" class="list-group-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fas fa-fw fa-chart-line"></i> Dashboard
            </a>
            
            <a href="{{ route('dokter.jadwal.index') }}" class="list-group-item {{ request()->routeIs('dokter.jadwal.*') ? 'active' : '' }}">
                <i class="fas fa-fw fa-calendar-alt"></i> Jadwal Saya
            </a>
            
            <a href="{{ route('dokter.appointment.index') }}" class="list-group-item {{ request()->routeIs('dokter.appointment.*') ? 'active' : '' }}">
                <i class="fas fa-fw fa-users"></i> Pasien Saya
            </a>
        
        @else {{-- Role Pasien/Mahasiswa --}}
            
            <a href="{{ route('dashboard') }}" class="list-group-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fas fa-fw fa-home"></i> Dashboard
            </a>
            <a href="{{ route('pasien.jadwal.index') }}" class="list-group-item {{ request()->routeIs('pasien.jadwal.*') ? 'active' : '' }}">
                <i class="fas fa-fw fa-calendar-check"></i> Buat Janji Temu
            </a>
            <a href="{{ route('pasien.appointment.index') }}" class="list-group-item {{ request()->routeIs('pasien.appointment.*') ? 'active' : '' }}">
                <i class="fas fa-fw fa-history"></i> Riwayat Konsultasi
            </a>

        @endif

        <hr class="mx-3 my-2" style="border-color: #e0e0e0;">

        <a href="{{ route('profile.edit') }}" class="list-group-item {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
            <i class="fas fa-fw fa-cog"></i> Pengaturan Akun
        </a>
        
        <a href="#" class="list-group-item" onclick="event.preventDefault(); document.getElementById('logout-form-sidebar').submit();">
            <i class="fas fa-fw fa-sign-out-alt"></i> Keluar
        </a>
        <form id="logout-form-sidebar" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>

    </div>
</nav>