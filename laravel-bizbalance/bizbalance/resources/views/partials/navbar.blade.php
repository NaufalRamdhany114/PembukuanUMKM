<header>
    <div class="logo">
        <img src="{{ asset('Gambar/logo.png') }}" alt="Logo BizBalance">
        <span>BizBalance</span>
    </div>
    <nav>
        <ul>
            <li><a href="{{ url('dashboard') }}"><img src="{{ asset('Gambar/dashboard.png') }}" alt="" class="nav-logo">Dashboard</a></li>
            <li><a href="{{ url('pencatatan') }}"><img src="{{ asset('Gambar/laporan.png') }}" alt="" class="nav-logo">Pencatatan</a></li>
            <li><a href="{{ url('laporan') }}"><img src="{{ asset('Gambar/keuangan.png') }}" alt="" class="nav-logo">Laporan</a></li>
            <li><a href="{{ url('logout') }}"><img src="{{ asset('Gambar/logout.png') }}" alt="" class="nav-logo">Logout</a></li>
        </ul>
    </nav>
    <div class="profil" id="profil-username">
        {{ Auth::user()->username ?? 'Guest' }}
    </div>
</header>
