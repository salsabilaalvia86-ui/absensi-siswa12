@extends('layouts.app')

@section('title', 'Input Absensi')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Input Absensi</h1>

        <a href="{{ route('guru.absensi.index') }}" class="btn btn-outline-secondary">
            Kembali
        </a>
    </div>

    {{-- Form pertama: memilih jadwal dan tanggal --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('guru.absensi.create') }}" method="GET">
                <div class="row g-3 align-items-end">
                    <div class="col-md-6">
                        <label for="jadwal_id" class="form-label">Jadwal Mengajar</label>

                        <select name="jadwal_id" id="jadwal_id" class="form-select" required>
                            <option value="">Pilih jadwal...</option>

                            @foreach ($jadwals as $jadwal)
                                <option value="{{ $jadwal->id }}"
                                    @selected(request('jadwal_id') == $jadwal->id)>
                                    {{ $jadwal->kelas }} — {{ $jadwal->hari }}
                                    {{ $jadwal->jam() }} — {{ $jadwal->mapel_nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="tanggal" class="form-label">Tanggal</label>

                        <input
                            type="date"
                            name="tanggal"
                            id="tanggal"
                            class="form-control"
                            value="{{ $tanggal }}"
                            required
                        >
                    </div>

                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            Tampilkan Siswa
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if ($selectedJadwal !== null)
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h2 class="h5 mb-1">
                    {{ $selectedJadwal->kelas }} — {{ $selectedJadwal->mapel_nama }}
                </h2>

                <small class="text-muted">
                    ({{ $selectedJadwal->hari }},
                    {{ $selectedJadwal->jam() }} ·
                    {{ \Illuminate\Support\Carbon::parse($tanggal)->format('d/m/Y') }})
                </small>
            </div>

            {{-- Form kedua: menyimpan absensi --}}
            <form action="{{ route('guru.absensi.store') }}" method="POST">
                @csrf

                <input type="hidden" name="jadwal_id" value="{{ $selectedJadwal->id }}">
                <input type="hidden" name="tanggal" value="{{ $tanggal }}">

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>NISN</th>
                                <th>Nama Siswa</th>
                                <th>Status</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($siswas as $siswa)
                                @php
                                    $absen = $absensiAda->get($siswa->id);
                                @endphp

                                <tr>
                                    <td>{{ $loop->iteration }}</td>

                                    <td>
                                        <code>{{ $siswa->nisn }}</code>
                                    </td>

                                    <td>{{ $siswa->nama }}</td>

                                    <td>
                                        <select
                                            name="status[{{ $siswa->id }}]"
                                            class="form-select"
                                            required
                                        >
                                            @foreach (\App\Models\Absensi::STATUS as $value => $label)
                                                <option
                                                    value="{{ $value }}"
                                                    @selected(old('status.' . $siswa->id, $absen?->status ?? 'hadir') === $value)
                                                >
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>

                                    <td>
                                        <input
                                            type="text"
                                            name="keterangan[{{ $siswa->id }}]"
                                            class="form-control"
                                            value="{{ old('keterangan.' . $siswa->id, $absen?->keterangan) }}"
                                            placeholder="Opsional"
                                        >
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        Tidak ada siswa pada kelas {{ $selectedJadwal->kelas }}.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($siswas->isNotEmpty())
                    <div class="card-body d-flex flex-wrap gap-2">
                        <button type="submit" class="btn btn-primary">
                            Simpan Absensi
                        </button>

                        <button type="button" id="tandaiSemuaHadir" class="btn btn-outline-success">
                            Tandai Semua Hadir
                        </button>
                    </div>
                @endif
            </form>
        </div>
    @else
        <div class="alert alert-info">
            Pilih jadwal dan tanggal terlebih dahulu, lalu klik
            <strong>Tampilkan Siswa</strong>.
        </div>
    @endif
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tombol = document.getElementById('tandaiSemuaHadir');

            if (tombol) {
                tombol.addEventListener('click', function () {
                    document.querySelectorAll('select[name^="status["]').forEach(function (select) {
                        select.value = 'hadir';
                    });
                });
            }
        });
    </script>
@endpush