@extends('layouts.guest')

@section('title', 'Cek Absensi Anak')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">

                <div class="text-center mb-4">
                    <h1 class="h2 fw-bold">Cek Absensi Anak</h1>
                    <p class="text-muted">
                        Masukkan NISN siswa untuk melihat rekap kehadiran dan riwayat absensi.
                    </p>
                </div>

                <div class="card shadow-sm mb-4">
                    <div class="card-body p-4">
                        <form method="GET" action="{{ route('ortu.index') }}">
                            <div class="mb-3">
                                <label for="nisn" class="form-label">NISN</label>
                                <input
                                    type="text"
                                    name="nisn"
                                    id="nisn"
                                    class="form-control"
                                    value="{{ request('nisn') }}"
                                    placeholder="Masukkan NISN siswa"
                                    maxlength="20"
                                    required
                                >
                            </div>

                            <button type="submit" class="btn btn-primary">
                                Cari
                            </button>
                        </form>
                    </div>
                </div>

                @if ($siswa !== null)
                    <div class="card shadow-sm mb-4">
                        <div class="card-body p-4">
                            <h2 class="h4 fw-bold mb-2">{{ $siswa->nama }}</h2>

                            <p class="text-muted mb-4">
                                NISN <code>{{ $siswa->nisn }}</code>
                                · Kelas {{ $siswa->kelas }}
                            </p>

                            <div class="text-center mb-4">
                                <h3 class="display-5 fw-bold text-primary">
                                    {{ $rekap['persentase'] }}%
                                </h3>
                                <p class="text-muted mb-0">
                                    Kehadiran dari {{ $rekap['total'] }} pertemuan
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

                            <div class="row g-3">
                                @foreach ($kartu as $status => [$label, $warna])
                                    <div class="col-6 col-md-3">
                                        <div class="border rounded p-3 text-center h-100">
                                            <h3 class="h2 fw-bold text-{{ $warna }} mb-1">
                                                {{ $rekap[$status] }}
                                            </h3>
                                            <p class="text-muted mb-0">{{ $label }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm">
                        <div class="card-header bg-white py-3">
                            <h2 class="h5 mb-0">Riwayat Absensi</h2>
                        </div>

                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
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
                                                <td colspan="6" class="text-center text-muted py-4">
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
                @endif

                <div class="mt-4">
                    <a href="{{ url('/') }}" class="text-decoration-none">
                        &larr; Kembali ke beranda
                    </a>
                </div>

            </div>
        </div>
    </div>
@endsection