<div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center">
        <div class="image">
            <img src="{{ auth()->user()->foto ? asset('storage/uploads/user/' . auth()->user()->foto) : asset('images/default.png') }}"
                 class="img-circle elevation-2" alt="User Image"
                 style="width: 35px; height: 35px; object-fit: cover;">
        </div>
        <div class="info">
            <a href="{{ route('profile.edit') }}" class="d-block">{{ auth()->user()->nama }}</a>
        </div>
    </div>

    <!-- SidebarSearch Form -->
    <div class="form-inline mt-2">
        <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
                <button class="btn btn-sidebar">
                    <i class="fas fa-search fa-fw"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
                <a href="{{ url('/') }}" class="nav-link {{ ($activeMenu == 'dashboard')? 'active' : '' }} ">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>Dashboard</p>
                </a>
            </li>

            <li class="nav-header">Data Pengguna</li>
            <li class="nav-item">
                <a href="{{ url('/level') }}" class="nav-link {{ ($activeMenu == 'level')? 'active' : '' }} ">
                    <i class="nav-icon fas fa-layer-group"></i>
                    <p>Level User</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/user') }}" class="nav-link {{ ($activeMenu == 'user')? 'active' : '' }}">
                    <i class="nav-icon far fa-user"></i>
                    <p>Data User</p>
                </a>
            </li>

            {{-- Tambahan Profil Saya --}}
            <li class="nav-item">
                <a href="{{ route('profile.edit') }}" class="nav-link {{ ($activeMenu == 'profile')? 'active' : '' }}">
                    <i class="nav-icon fas fa-user-circle"></i>
                    <p>Profil Saya</p>
                </a>
            </li>

            <li class="nav-header">Data Barang</li>
            <li class="nav-item">
                <a href="{{ url('/kategori') }}" class="nav-link {{ ($activeMenu == 'kategori')? 'active' : '' }} ">
                    <i class="nav-icon far fa-bookmark"></i>
                    <p>Kategori Barang</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/supplier') }}" class="nav-link {{ ($activeMenu == 'supplier')? 'active' : '' }} ">
                    <i class="nav-icon fas fa-truck"></i>
                    <p>Data Supplier</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/barang') }}" class="nav-link {{ ($activeMenu == 'barang')? 'active' : '' }} ">
                    <i class="nav-icon far fa-list-alt"></i>
                    <p>Data Barang</p>
                </a>
            </li>

            <li class="nav-header">Data Transaksi</li>
            <li class="nav-item">
                <a href="{{ url('/stok') }}" class="nav-link {{ ($activeMenu == 'stok')? 'active' : '' }} ">
                    <i class="nav-icon fas fa-cubes"></i>
                    <p>Stok Barang</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ url('/transaksi') }}" class="nav-link {{ ($activeMenu == 'penjualan')? 'active' : '' }} ">
                    <i class="nav-icon fas fa-cash-register"></i>
                    <p>Transaksi Penjualan</p>
                </a>
            </li>

            <li class="nav-item">
                <form id="logout-form-sidebar" action="{{ url('logout') }}" method="GET">
                    @csrf
                    <button type="submit" class="nav-link btn btn-danger text-left w-100">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </li>
        </ul>
    </nav>
</div>

<style>
    /* Untuk semua teks di sidebar */
    .sidebar, 
    .nav-sidebar .nav-link, 
    .nav-sidebar .nav-header,
    .sidebar .user-panel .info a,
    .sidebar .form-control-sidebar {
        color: #ffffff !important; /* Putih terang */
    }

    /* Ikon sidebar */
    .nav-icon {
        color: #ffffff !important;
    }

    /* Teks menu aktif */
    .nav-sidebar .nav-link.active {
        background-color: #0d6efd !important;
        color: #fff !important;
        font-weight: bold;
    }

    /* Text shadow agar teks lebih terbaca di gradasi */
    .nav-sidebar .nav-link p,
    .sidebar .user-panel .info a,
    .nav-sidebar .nav-header {
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.5);
    }

    /* Header POS SYSTEM */
    .brand-text {
        color: #ffffff !important;
        font-weight: bold;
    }

    /* Placeholder Search Box */
    .form-control::placeholder {
        color: #ccc;
    }
/* Tambahkan garis pemisah antar menu */
.nav-sidebar .nav-item:not(:last-child) .nav-link {
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    padding-bottom: 0.4rem; /* dikurangi */
    margin-bottom: 0.4rem;  /* dikurangi */
}

/* Garis untuk header section */
.nav-sidebar .nav-header {
    border-bottom: 1px solid rgba(255, 255, 255, 0.15);
    padding-bottom: 0.3rem;  /* dikurangi */
    margin: 1rem 0 0.5rem;   /* dikurangi */
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 0.8px;
}

/* Penyesuaian untuk logout agar tidak ada garis */
.nav-sidebar .nav-item:last-child {
    margin-top: 1rem;  /* dikurangi */
    border-top: 1px solid rgba(255, 255, 255, 0.15);
    padding-top: 0.6rem; /* dikurangi */
}

/* Perbaikan spacing untuk item aktif */
.nav-sidebar .nav-link.active {
    margin-bottom: 0.4rem; /* dikurangi */
}

</style>
