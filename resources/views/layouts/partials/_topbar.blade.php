<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
    <div class="container-fluid">

        <button class="btn btn-primary" id="menu-toggle">
            <i class="fa-solid fa-bars"></i>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        
                        <img class="rounded-circle me-2" src="{{ asset('storage/avatars/' . Auth::user()->avatar) }}" style="height: 30px; width: 30px; object-fit: cover;">
                        {{ Auth::user()->name }}
                        
                    </a>
                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        
                        <a class="dropdown-item" href="{{ route('profile.edit') }}">Profil Saya</a>
                        <div class="dropdown-divider"></div>
                        
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                         document.getElementById('logout-form-topbar').submit();">
                            Keluar (Logout)
                        </a>
                        <form id="logout-form-topbar" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>