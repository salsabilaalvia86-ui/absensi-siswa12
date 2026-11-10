@extends('layouts.app')

@section('title', 'Jadwal Pelajaran')

@section('content')
    <div class="mb-4">
        <h1 class="h3 mb-1">Jadwal Pelajaran</h1>
        <p class="text-muted mb-0">
            {{ $siswa->nama }} · Kelas {{ $siswa->kelas }}
        </p>

        <div class="text-muted small mt-2">
            {{ now()->format('d/m/Y') }} · {{ \App\Models\Jadwal::hariIni() }}
        </div>
    </div>

    @forelse ($jadwals as $hari => $jadwalHari)
        @php
            $isToday = $hari === \App\Models\Jadwal::hariIni();
        @endphp

        <div class="card shadow-sm mb-4 {{ $isToday ? 'border-primary border-2' : '' }}">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h2 class="h5 mb-0">
                    {{ $hari }}
                </h2>

                <div class="d-flex align-items-center gap-2">
                    <span class="text-muted small">
                        {{ $jadwalHari->count() }} jam pelajaran
                    </span>

                    @if ($isToday)
                        <span class="badge bg-primary">Hari ini</span>
                    @endif
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Jam</th>
                            <th>Mapel</th>
                            <th>Guru</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($jadwalHari as $jadwal)
                            <tr>
                                <td>{{ $jadwal->jam() }}</td>
                                <td>{{ $jadwal->mapel_nama }}</td>
                                <td>{{ $jadwal->guru_nama }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @empty
        <div class="alert alert-info">
            Belum ada jadwal untuk kelas {{ $siswa->kelas }}.
        </div>
    @endforelse
@endsection