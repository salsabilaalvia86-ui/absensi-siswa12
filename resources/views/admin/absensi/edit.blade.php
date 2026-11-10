@extends('layouts.app')

@section('title', 'Ubah Absensi')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Ubah Catatan Absensi</h1>
        <a href="{{ route('admin.absensi.index') }}" class="btn btn-outline-secondary">
            Kembali
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <dl class="row mb-0">
                <dt class="col-md-3">Siswa</dt>
                <dd class="col-md-9">
                    {{ $absensi->siswa_nama }}
                    (<code>{{ $absensi->siswa_nisn }}</code>)
                </dd>

                <dt class="col-md-3">Jadwal</dt>
                <dd class="col-md-9">
                    {{ $absensi->jadwal_kelas }} — {{ $absensi->mapel_nama }}
                    <br>
                    <small class="text-muted">
                        ({{ $absensi->jadwal_hari }}, {{ $absensi->jadwalJam() }})
                    </small>
                </dd>

                <dt class="col-md-3">Guru</dt>
                <dd class="col-md-9">{{ $absensi->guru_nama }}</dd>

                <dt class="col-md-3">Tanggal</dt>
                <dd class="col-md-9">
                    {{ $absensi->tanggal->format('d/m/Y') }}
                </dd>
            </dl>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.absensi.update', $absensi->id) }}"
        class="card card-body mt-3">
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
            <textarea name="keterangan" id="keterangan" class="form-control"
                rows="3" placeholder="Opsional">{{ old('keterangan', $absensi->keterangan) }}</textarea>
            @error('keterangan')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.absensi.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
@endsection