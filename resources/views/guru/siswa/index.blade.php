@extends('layouts.app')

@section('title', 'Data Siswa')

@section('content')
    <div class="mb-4">
        <h1 class="h3 mb-1">Siswa yang Diajar</h1>
        <p class="text-muted mb-0">{{ $guru->nama }}</p>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('guru.siswa.index') }}" method="GET">
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label for="kelas" class="form-label">Filter Kelas</label>
                        <select name="kelas" id="kelas" class="form-select">
                            <option value="">Semua Kelas</option>

                            @foreach ($kelasList as $kelas)
                                <option value="{{ $kelas }}"
                                    @selected(request('kelas') == $kelas)>
                                    {{ $kelas }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-5">
                        <label for="q" class="form-label">Cari Nama/NISN</label>
                        <input
                            type="text"
                            name="q"
                            id="q"
                            class="form-control"
                            placeholder="Masukkan nama atau NISN..."
                            value="{{ request('q') }}"
                        >
                    </div>

                    <div class="col-md-3 d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            Cari
                        </button>

                        <a href="{{ route('guru.siswa.index') }}" class="btn btn-outline-secondary">
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
                        <th>NISN</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Jenis Kelamin</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($siswas as $siswa)
                        <tr>
                            <td>{{ $siswas->firstItem() + $loop->index }}</td>
                            <td><code>{{ $siswa->nisn }}</code></td>
                            <td>{{ $siswa->nama }}</td>
                            <td>{{ $siswa->kelas }}</td>
                            <td>{{ $siswa->jenisKelaminLabel() }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                Belum ada data siswa.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-body">
            {{ $siswas->links() }}
        </div>
    </div>
@endsection