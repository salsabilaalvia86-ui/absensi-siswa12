@extends('layouts.app')

@section('title', 'Absensi Saya')

@section('content')
    <div class="mb-4">
        <h1 class="h3 mb-1">Absensi Saya</h1>
        <p class="text-muted mb-0">
            {{ $siswa->nama }} · Kelas {{ $siswa->kelas }}
        </p>
    </div>

    @php
        $kartu = [
            'hadir' => ['Hadir', 'success'],
            'sakit' => ['Sakit', 'warning'],
            'izin' => ['Izin', 'info'],
            'alfa' => ['Alfa', 'danger'],
        ];
    @endphp

    <div class="card shadow-sm mb-4">
        <div class="card-body text-center">
            <h2 class="display-5 fw-bold text-primary mb-1">
                {{ $rekap['persentase'] }}%
            </h2>
            <p class="text-muted mb-0">
                Kehadiran dari {{ $rekap['total'] }} pertemuan
            </p>
        </div>
    </div>

    <div class="row g-3 mb-4">
        @foreach ($kartu as $status => [$label, $warna])
            <div class="col-6 col-md-3">
                <div class="card shadow-sm h-100">
                    <div class="card-body text-center">
                        <h3 class="h2 fw-bold text-{{ $warna }} mb-1">
                            {{ $rekap[$status] }}
                        </h3>
                        <p class="text-muted mb-0">{{ $label }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('siswa.absensi.index') }}">
                <div class="row g-2 align-items-end">
                    <div class="col-md-4">
                        <label for="status" class="form-label">Filter Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="">Semua Status</option>

                            @foreach (\App\Models\Absensi::STATUS as $value => $label)
                                <option value="{{ $value }}"
                                    @selected(request('status') === $value)>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary">
                            Cari
                        </button>
                    </div>

                    <div class="col-auto">
                        <a href="{{ route('siswa.absensi.index') }}"
                           class="btn btn-outline-secondary">
                            Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h2 class="h5 mb-0">Riwayat Absensi</h2>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Tanggal</th>
                            <th>Mapel</th>
                            <th>Guru</th>
                            <th>Jam</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($absensis as $absensi)
                            <tr>
                                <td>{{ $absensis->firstItem() + $loop->index }}</td>
                                <td>{{ $absensi->tanggal->format('d/m/Y') }}</td>
                                <td>{{ $absensi->mapel_nama }}</td>
                                <td>{{ $absensi->guru_nama }}</td>
                                <td>{{ $absensi->jadwalJam() }}</td>
                                <td>
                                    <span class="badge bg-{{ $absensi->status === 'hadir' ? 'success' : ($absensi->status === 'sakit' ? 'warning text-dark' : ($absensi->status === 'izin' ? 'info text-dark' : 'danger')) }}">
                                        {{ $absensi->statusLabel() }}
                                    </span>
                                </td>
                                <td>{{ $absensi->keterangan ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    Belum ada data absensi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if ($absensis->hasPages())
            <div class="card-footer bg-white">
                {{ $absensis->links() }}
            </div>
        @endif
    </div>
@endsection