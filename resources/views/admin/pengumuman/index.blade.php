@extends('admin.layouts.master')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Daftar Pengumuman</h3>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <a href="{{ route('admin.pengumuman.create') }}" class="btn btn-primary mb-3">Tambah Pengumuman</a>

                            <table class="table table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th>No</th>
                                        <th>Judul</th>
                                        <th>Nomor Surat</th>
                                        <th>Kepada</th>
                                        <th>Tanggal Pelaksanaan</th>
                                        <th>Tempat</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pengumumans as $pengumuman)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $pengumuman->judul }}</td> <!-- Judul Pengumuman -->
                                            <td>{{ $pengumuman->nomor_surat }}</td>
                                            <td>{{ $pengumuman->kepada }}</td>
                                            <td>
                                                {{-- Menggabungkan hari dan waktu untuk menampilkan tanggal pelaksanaan --}}
                                                {{ $pengumuman->hari }},
                                                {{ \Carbon\Carbon::parse($pengumuman->waktu)->format('H:i') }}
                                            </td>
                                            <td>{{ $pengumuman->tempat }}</td>
                                            <td>
                                                <a href="{{ route('admin.pengumuman.show', $pengumuman->id) }}" class="btn btn-info btn-sm">Lihat</a>
                                                <a href="{{ route('admin.pengumuman.edit', $pengumuman->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                                <a href="{{ route('admin.pengumuman.cetak', $pengumuman->id) }}" class="btn btn-success btn-sm" target="_blank">Cetak PDF</a>
                                                <form action="{{ route('admin.pengumuman.destroy', $pengumuman->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengumuman ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
