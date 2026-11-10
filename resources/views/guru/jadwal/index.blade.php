@extends('layouts.app')

@section('title', 'Jadwal Mengajar')

@section('content')
    <div class="mb-4">
        <h1 class="h3 mb-1">Jadwal Mengajar</h1>
        <p class="text-muted mb-0">{{ $guru->nama }}</p>
    </div>

    @forelse ($jadwals as $hari => $jadwalHari)
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h2 class="h5 mb-0">
                    @php
                        $warnaBadge = match ($hari) {
                            'Senin', 'Selasa' => 'bg-primary',
                            'Rabu', 'Kamis' => 'bg-success',
                            'Jumat' => 'bg-warning text-dark',
                            default => 'bg-secondary',
                        };
                    @endphp

                    <span class="badge {{ $warnaBadge }}">
                        {{ $hari }}
                    </span>
                </h2>

                <span class="text-muted small">
                    {{ $jadwalHari->count() }} jam pelajaran
                </span>
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
                        @foreach ($jadwalHari as $jadwal)
                            <tr>
                                <td>{{ $jadwal->jam() }}</td>
                                <td>{{ $jadwal->kelas }}</td>
                                <td>{{ $jadwal->mapel_nama }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @empty
        <div class="alert alert-info">
            Belum ada jadwal mengajar untuk Anda.
        </div>
    @endforelse
@endsection