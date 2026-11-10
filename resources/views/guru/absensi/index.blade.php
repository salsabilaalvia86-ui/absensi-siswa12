@extends('layouts.app')

@section('title', 'Absensi')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Absensi</h1>

        <a href="{{ route('guru.absensi.create') }}" class="btn btn-primary">
            Input Absensi
        </a>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('guru.absensi.index') }}" method="GET">
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label for="jadwal_id" class="form-label">Jadwal</label>
                        <select name="jadwal_id" id="jadwal_id" class="form-select">
                            <option value="">Semua Jadwal</option>

                            @foreach ($jadwals as $jadwal)
                                <option value="{{ $jadwal->id }}"
                                    @selected(request('jadwal_id') == $jadwal->id)>
                                    {{ $jadwal->kelas }} — {{ $jadwal->hari }}
                                    {{ $jadwal->jam() }} — {{ $jadwal->mapel_nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input
                            type="date"
                            name="tanggal"
                            id="tanggal"
                            class="form-control"
                            value="{{ request('tanggal') }}"
                        >
                    </div>

                    <div class="col-md-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="">Semua Status</option>

                            @foreach (\App\Models\Absensi::STATUS as $value => $label)
                                <option value="{{ $value }}"
                                    @selected(request('status') == $value)>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2 d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            Cari
                        </button>

                        <a href="{{ route('guru.absensi.index') }}"
                            class="btn btn-outline-secondary">
                            Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Tanggal</th>
                        <th>Kelas</th>
                        <th>Mapel</th>
                        <th>Jam</th>
                        <th>Siswa</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($absensis as $absensi)
                        <tr>
                            <td>{{ $absensis->firstItem() + $loop->index }}</td>
                            <td>{{ $absensi->tanggal->format('d/m/Y') }}</td>
                            <td>{{ $absensi->jadwal_kelas }}</td>
                            <td>{{ $absensi->mapel_nama }}</td>
                            <td>{{ $absensi->jadwalJam() }}</td>
                            <td>
                                <div>{{ $absensi->siswa_nama }}</div>
                                <small class="text-muted">
                                    {{ $absensi->siswa_nisn }}
                                </small>
                            </td>
                            <td>{{ $absensi->statusLabel() }}</td>
                            <td>{{ $absensi->keterangan ?? '-' }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('guru.absensi.edit', $absensi) }}"
                                        class="btn btn-sm btn-warning">
                                        Ubah
                                    </a>

                                    <form
                                        action="{{ route('guru.absensi.destroy', $absensi) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus data absensi ini?')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-sm btn-danger">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">
                                Belum ada data absensi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-body">
            {{ $absensis->links() }}
        </div>
    </div>
@endsection