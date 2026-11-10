@extends('layouts.app')

@section('title', 'Mapel Diampu')

@section('content')
    <div class="mb-4">
        <h1 class="h3 mb-1">Mata Pelajaran Diampu</h1>
        <p class="text-muted mb-0">{{ $guru->nama }}</p>
    </div>

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Kode</th>
                        <th>Nama Mapel</th>
                        <th>Jumlah Kelas/Jadwal</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($mapels as $mapel)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <code>{{ $mapel->kode }}</code>
                            </td>
                            <td>{{ $mapel->nama }}</td>
                            <td>{{ $mapel->jumlah_kelas }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                Belum ada mapel yang diampu.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection