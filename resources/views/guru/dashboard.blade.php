@extends('layouts.app')

@section('title', 'Dashboard Guru')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">Dashboard Guru</h1>
            <p class="text-muted mb-0">
                Selamat datang, {{ $guru->nama }}.
            </p>
        </div>

        <div class="text-end">
            <span class="text-muted">
                {{ now()->format('d/m/Y') }} · {{ \App\Models\Jadwal::hariIni() }}
            </span>
        </div>
    </div>

    @php
        $kartu = [
            [
                'label' => 'Mapel Diampu',
                'value' => $stats['mapel'],
                'route' => route('guru.mapel.index'),
            ],
            [
                'label' => 'Jadwal Mengajar',
                'value' => $stats['jadwal'],
                'route' => route('guru.jadwal.index'),
            ],
            [
                'label' => 'Siswa Diajar',
                'value' => $stats['siswa'],
                'route' => route('guru.siswa.index'),
            ],
            [
                'label' => 'Absensi Hari Ini',
                'value' => $stats['absensi_hari_ini'],
                'route' => route('guru.absensi.index'),
            ],
        ];
    @endphp

    <div class="row g-3 mb-4">
        @foreach ($kartu as $item)
            <div class="col-md-6 col-xl-3">
                <a href="{{ $item['route'] }}" class="text-decoration-none text-dark">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <h2 class="display-6 fw-bold mb-1">
                                {{ $item['value'] }}
                            </h2>
                            <p class="text-muted mb-0">
                                {{ $item['label'] }}
                            </p>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h2 class="h5 mb-0">
                Jadwal Mengajar Hari Ini ({{ \App\Models\Jadwal::hariIni() }})
            </h2>

            <a href="{{ route('guru.absensi.create') }}" class="btn btn-sm btn-primary">
                Input Absensi
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Jam</th>
                        <th>Kelas</th>
                        <th>Mapel</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($jadwalHariIni as $jadwal)
                        <tr>
                            <td>{{ $jadwal->jam() }}</td>
                            <td>{{ $jadwal->kelas }}</td>
                            <td>{{ $jadwal->mapel_nama }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted py-4">
                                Tidak ada jadwal mengajar hari ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection