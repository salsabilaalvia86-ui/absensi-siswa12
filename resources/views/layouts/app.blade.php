<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Absensi Siswa')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    @stack('styles')
</head>
<body class="bg-body-tertiary">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">

        <a class="navbar-brand" href="{{ route('home') }}">
            {{ config('app.name') }}
        </a>

        <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse"
                data-bs-target="#mainNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNavbar">

            <ul class="navbar-nav me-auto">

                @auth
                    @if (auth()->user()->isAdmin())

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                               href="{{ route('admin.dashboard') }}">
                                Dashboard
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.jadwal.*') ? 'active' : '' }}"
                               href="{{ route('admin.jadwal.index') }}">
                                Jadwal
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.mapel.*') ? 'active' : '' }}"
                               href="{{ route('admin.mapel.index') }}">
                                Mapel
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.guru.*') ? 'active' : '' }}"
                               href="{{ route('admin.guru.index') }}">
                                Guru
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.siswa.*') ? 'active' : '' }}"
                               href="{{ route('admin.siswa.index') }}">
                                Siswa
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.absensi.*') ? 'active' : '' }}"
                               href="{{ route('admin.absensi.index') }}">
                                Absensi
                            </a>
                        </li>

                    @elseif (auth()->user()->isGuru())

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('guru.dashboard') }}">Dashboard</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('guru.jadwal.index') }}">Jadwal</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('guru.mapel.index') }}">Mapel</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('guru.siswa.index') }}">Siswa</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('guru.absensi.index') }}">Absensi</a>
                        </li>

                    @else

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('siswa.jadwal.index') }}">Jadwal</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('siswa.mapel.index') }}">Mapel</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('siswa.absensi.index') }}">Absensi</a>
                        </li>

                    @endif

                @else

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('ortu.index') }}">
                            Cek Absensi Anak
                        </a>
                    </li>

                @endauth

            </ul>

            <ul class="navbar-nav">

                @auth

                    <li class="nav-item">
                        <span class="nav-link">
                            {{ auth()->user()->name }}
                            ({{ ucfirst(auth()->user()->role) }})
                        </span>
                    </li>

                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf

                            <button type="submit" class="btn btn-outline-light btn-sm mt-1">
                                Keluar
                            </button>
                        </form>
                    </li>

                @else

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            Masuk
                        </a>
                    </li>

                @endauth

            </ul>

        </div>
    </div>
</nav>

<main class="container py-4">

    @include('partials.flash')

    @include('partials.errors')

    @yield('content')

</main>

<footer class="text-center py-3 bg-light mt-5">
    {{ config('app.name') }} · Sistem Absensi Siswa
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

@stack('scripts')

</body>
</html>