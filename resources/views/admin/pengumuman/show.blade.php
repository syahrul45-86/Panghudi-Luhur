@extends('admin.layouts.master')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Detail Pengumuman</h3>
                        </div>
                        <div class="card-body">
                            <!-- Menampilkan gambar sebagai latar belakang -->
                            @if($pengumuman->gambar)
                                <div class="bg-image" style="background-image: url('{{ asset('storage/' . $pengumuman->gambar) }}'); background-size: cover; background-position: center; height: 300px;">
                                    <div class="bg-overlay">
                                        <h2 class="text-white p-5">Pengumuman: {{ $pengumuman->judul }}</h2>
                                    </div>
                                </div>
                            @endif

                            <table class="table table-bordered mt-4">
                                <thead>
                                    <tr>
                                        <th>Nomor Surat</th>
                                        <th>{{ $pengumuman->nomor_surat }}</th>
                                    </tr>
                                    <tr>
                                        <th>Kepada</th>
                                        <th>{{ $pengumuman->kepada }}</th>
                                    </tr>
                                    <tr>
                                        <th>Perihal</th>
                                        <th>{{ $pengumuman->perihal }}</th>
                                    </tr>
                                    <tr>
                                        <th>Hari</th>
                                        <th>{{ $pengumuman->hari }}</th>
                                    </tr>
                                    <tr>
                                        <th>Waktu</th>
                                        <th>{{ date('H:i', strtotime($pengumuman->waktu)) }}</th>
                                    </tr>
                                    <tr>
                                        <th>Tempat</th>
                                        <th>{{ $pengumuman->tempat }}</th>
                                    </tr>
                                    <tr>
                                        <th>Acara</th>
                                        <th>{{ $pengumuman->acara }}</th>
                                        <td>{{ $pengumuman->ttd_ketua }}</td>
                                    </tr>
                                    <tr>
                                        <th>Deskripsi</th>
                                        <td>{{ $pengumuman->deskripsi }}</td>
                                        <td>{{ $pengumuman->gambar }}</td>

                                    </tr>
                                </thead>
                            </table>

                            <a href="{{ route('admin.pengumuman.index') }}" class="btn btn-primary">Kembali ke Daftar Pengumuman</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        .bg-image {
            position: relative;
            width: 100%;
            height: 300px;
            color: white;
            text-align: center;
            background-color: rgba(0, 0, 0, 0.5); /* Overlay effect */
        }
        .bg-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
@endsection
