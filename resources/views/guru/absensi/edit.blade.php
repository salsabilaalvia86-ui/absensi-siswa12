@extends('layouts.app')

@section('title', 'Ubah Absensi')

@section('content')
    <div class="mb-4">
        <h1 class="h3 mb-1">Ubah Catatan Absensi</h1>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            {{-- Informasi siswa --}}
            <div class="mb-3">
                <label class="form-label fw-bold">Siswa</label>
                <div>
                    {{ $absensi->siswa_nama }}
                    (<code>{{ $absensi->siswa_nisn }}</code>)
                </div>
            </div>

            {{-- Informasi jadwal --}}
            <div class="mb-3">
                <label class="form-label fw-bold">Jadwal</label>
                <div>
                    {{ $absensi->jadwal_kelas }} — {{ $absensi->mapel_nama }}
                    <br>
                    <small class="text-muted">
                        ({{ $absensi->jadwal_hari }},
                        {{ $absensi->jadwalJam() }})
                    </small>
                </div>
            </div>

            {{-- Informasi tanggal --}}
            <div class="mb-4">
                <label class="form-label fw-bold">Tanggal</label>
                <div>{{ $absensi->tanggal->format('d/m/Y') }}</div>
            </div>

            <hr>

            {{-- Form ubah absensi --}}
            <form action="{{ route('guru.absensi.update', $absensi) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>

                    <select name="status" id="status" class="form-select" required>
                        @foreach (\App\Models\Absensi::STATUS as $value => $label)
                            <option value="{{ $value }}"
                                @selected(old('status', $absensi->status) === $value)>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>

                    @error('status')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="keterangan" class="form-label">Keterangan</label>

                    <textarea
                        name="keterangan"
                        id="keterangan"
                        class="form-control"
                        rows="3"
                        placeholder="Masukkan keterangan (opsional)"
                    >{{ old('keterangan', $absensi->keterangan) }}</textarea>

                    @error('keterangan')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        Simpan
                    </button>

                    <a href="{{ route('guru.absensi.index') }}"
                        class="btn btn-outline-secondary">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection