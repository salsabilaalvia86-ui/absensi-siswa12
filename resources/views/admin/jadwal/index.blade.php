@extends('layouts.app')

@section('title', 'Data Jadwal')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Jadwal Pelajaran</h1>

        <a href="{{ route('admin.jadwal.create') }}" class="btn btn-primary">
            Tambah Jadwal
        </a>
    </div>

    <form method="GET" action="{{ route('admin.jadwal.index') }}" class="card card-body mb-3">
        <div class="row g-2">
            <div class="col-md-4">
                <select name="hari" class="form-select">
                    <option value="">Semua Hari</option>
                    @foreach (\App\Models\Jadwal::HARI as $hari)
                        <option value="{{ $hari }}" @selected(request('hari') === $hari)>
                            {{ $hari }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <select name="kelas" class="form-select">
                    <option value="">Semua Kelas</option>
                    @foreach ($kelasList as $kelas)
                        <option value="{{ $kelas }}" @selected(request('kelas') === $kelas)>
                            {{ $kelas }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    Cari
                </button>

                <a href="{{ route('admin.jadwal.index') }}" class="btn btn-outline-secondary">
                    Reset
                </a>
            </div>
        </div>
    </form>

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Hari</th>
                        <th>Jam</th>
                        <th>Kelas</th>
                        <th>Mapel</th>
                        <th>Guru</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($jadwals as $jadwal)
                        <tr>
                            <td>{{ $jadwals->firstItem() + $loop->index }}</td>

                            <td>
                                <span class="badge text-bg-{{ $jadwal->badgeHari() }}">
                                    {{ $jadwal->hari }}
                                </span>
                            </td>

                            <td>{{ $jadwal->jam() }}</td>
                            <td>{{ $jadwal->kelas }}</td>
                            <td>{{ $jadwal->mapel_nama }}</td>
                            <td>{{ $jadwal->guru_nama }}</td>

                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('admin.jadwal.edit', $jadwal) }}"
                                       class="btn btn-sm btn-warning">
                                        Ubah
                                    </a>

                                    <form action="{{ route('admin.jadwal.destroy', $jadwal) }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus jadwal ini?')">
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
                            <td colspan="7" class="text-center text-muted py-4">
                                Belum ada data jadwal.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $jadwals->links() }}
    </div>
@endsection