@extends('layouts.app')

@section('title', 'Data Absensi')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Data Absensi</h1>

        <a href="{{ route('admin.absensi.create') }}" class="btn btn-primary">
            Input Absensi
        </a>
    </div>

    <form method="GET" action="{{ route('admin.absensi.index') }}" class="card card-body mb-3">
        <div class="row g-2">
            <div class="col-md-4">
                <select name="jadwal_id" class="form-select">
                    <option value="">Semua Jadwal</option>
                    @foreach ($jadwals as $jadwal)
                        <option value="{{ $jadwal->id }}" @selected((string) request('jadwal_id') === (string) $jadwal->id)>
                            {{ $jadwal->kelas }} — {{ $jadwal->hari }} {{ $jadwal->jam() }} — {{ $jadwal->mapel_nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <input type="date" name="tanggal" class="form-control"
                       value="{{ request('tanggal') }}" placeholder="Tanggal">
            </div>

            <div class="col-md-4">
                <select name="status" class="form-select">
                    <option value="">Semua Status</option>
                    @foreach (\App\Models\Absensi::STATUS as $value => $label)
                        <option value="{{ $value }}" @selected(request('status') === $value)>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="d-flex gap-2 mt-3">
            <button type="submit" class="btn btn-primary">Cari</button>
            <a href="{{ route('admin.absensi.index') }}" class="btn btn-outline-secondary">Reset</a>
        </div>
    </form>

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
                            <td>{{ $absensi->siswa_nama }}</td>

                            <td>
                                <span class="badge text-bg-{{ $absensi->badgeStatus() }}">
                                    {{ $absensi->statusLabel() }}
                                </span>
                            </td>

                            <td>{{ $absensi->keterangan ?? '-' }}</td>

                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('admin.absensi.edit', $absensi->id) }}"
                                       class="btn btn-sm btn-warning">
                                        Ubah
                                    </a>

                                    <form action="{{ route('admin.absensi.destroy', $absensi->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus absensi ini?')">
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
    </div>

    <div class="mt-3">
        {{ $absensis->links() }}
    </div>
@endsection