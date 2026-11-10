@extends('layouts.app')

@section('title', 'Mata Pelajaran')

@section('content')
    <div class="mb-4">
        <h1 class="h3 mb-1">Mata Pelajaran</h1>
        <p class="text-muted mb-0">
            {{ $siswa->nama }} · Kelas {{ $siswa->kelas }}
        </p>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Kode</th>
                            <th>Nama Mapel</th>
                            <th>Guru Pengampu</th>
                            <th>Jadwal</th>
                            <th>Pertemuan</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($jadwals as $jadwalMapel)
                            @php
                                $pertama = $jadwalMapel->first();
                            @endphp

                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td>
                                    <code>{{ $pertama->mapel_kode }}</code>
                                </td>

                                <td>{{ $pertama->mapel_nama }}</td>

                                <td>
                                    {{ $jadwalMapel->pluck('guru_nama')->unique()->implode(', ') }}
                                </td>

                                <td>
                                    @foreach ($jadwalMapel as $jadwal)
                                        <div class="small mb-1">
                                            {{ $jadwal->hari }}, {{ $jadwal->jam() }}
                                        </div>
                                    @endforeach
                                </td>

                                <td>{{ $jadwalMapel->count() }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    Belum ada data mapel.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection