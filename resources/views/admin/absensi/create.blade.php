@extends('layouts.app')

@section('title', 'Input Absensi')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Input Absensi</h1>
        <a href="{{ route('admin.absensi.index') }}" class="btn btn-outline-secondary">
            Kembali
        </a>
    </div>

    {{-- Form pertama: memilih jadwal dan tanggal --}}
    <form method="GET" action="{{ route('admin.absensi.create') }}" class="card card-body mb-3">
        <div class="row g-3">
            <div class="col-md-8">
                <label for="jadwal_id" class="form-label">Jadwal</label>
                <select name="jadwal_id" id="jadwal_id" class="form-select" required>
                    <option value="">Pilih jadwal...</option>
                    @foreach ($jadwals as $jadwal)
                        <option value="{{ $jadwal->id }}"
                            @selected((string) request('jadwal_id') === (string) $jadwal->id)>
                            {{ $jadwal->kelas }} — {{ $jadwal->hari }}
                            {{ $jadwal->jam() }} — {{ $jadwal->mapel_nama }}
                            ({{ $jadwal->guru_nama }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <label for="tanggal" class="form-label">Tanggal</label>
                <input type="date" name="tanggal" id="tanggal"
                    class="form-control" value="{{ $tanggal }}" required>
            </div>
        </div>

        <div class="mt-3">
            <button type="submit" class="btn btn-primary">
                Tampilkan Siswa
            </button>
        </div>
    </form>

    @if ($selectedJadwal !== null)
        <div class="alert alert-info">
            <strong>{{ $selectedJadwal->kelas }} — {{ $selectedJadwal->mapel_nama }}</strong>
            <br>
            {{ $selectedJadwal->hari }}, {{ $selectedJadwal->jam() }}
            · {{ $selectedJadwal->guru_nama }}
            · {{ \Illuminate\Support\Carbon::parse($tanggal)->format('d/m/Y') }}
        </div>

        {{-- Form kedua: mengirim seluruh absensi --}}
        <form method="POST" action="{{ route('admin.absensi.store') }}">
            @csrf

            <input type="hidden" name="jadwal_id" value="{{ $selectedJadwal->id }}">
            <input type="hidden" name="tanggal" value="{{ $tanggal }}">

            <div class="card shadow-sm">
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
                                    <td>{{ $siswa->nisn }}</td>
                                    <td>{{ $siswa->nama }}</td>
                                    <td>
                                        <select name="status[{{ $siswa->id }}]"
                                            class="form-select form-select-sm js-status" required>
                                            @foreach (\App\Models\Absensi::STATUS as $value => $label)
                                                <option value="{{ $value }}"
                                                    @selected(old('status.' . $siswa->id, $absen?->status ?? 'hadir') === $value)>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text"
                                            name="keterangan[{{ $siswa->id }}]"
                                            class="form-control form-control-sm"
                                            value="{{ old('keterangan.' . $siswa->id, $absen?->keterangan) }}"
                                            placeholder="Opsional">
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
            </div>

            @if ($siswas->isNotEmpty())
                <div class="d-flex justify-content-between mt-3">
                    <button type="submit" class="btn btn-primary">
                        Simpan Absensi
                    </button>

                    <button type="button" id="btn-hadir" class="btn btn-success">
                        Tandai Semua Hadir
                    </button>
                </div>
            @endif
        </form>
    @else
        <div class="alert alert-secondary">
            Pilih jadwal dan tanggal terlebih dahulu, lalu klik
            <strong>Tampilkan Siswa</strong>.
        </div>
    @endif
@endsection

@push('scripts')
    <script>
        document.getElementById('btn-hadir')?.addEventListener('click', function () {
            document.querySelectorAll('.js-status').forEach(function (select) {
                select.value = 'hadir';
            });
        });
    </script>
@endpush