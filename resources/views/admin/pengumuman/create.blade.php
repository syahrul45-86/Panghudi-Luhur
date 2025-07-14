@extends('admin.layouts.master')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Tambah Pengumuman</h3>
                        </div>
                        <div class="card-body">
                            @if (session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif

                            <form action="{{ route('admin.pengumuman.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="judul">Judul</label>
                                    <input type="text" class="form-control" id="judul" name="judul" value="{{ old('judul') }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="alamat">Alamat</label>
                                    <input type="text" class="form-control" id="alamat" name="alamat" value="{{ old('alamat') }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="nomor_surat">Nomor Surat</label>
                                    <input type="text" class="form-control" id="nomor_surat" name="nomor_surat" value="{{ old('nomor_surat') }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="perihal">Perihal</label>
                                    <input type="text" class="form-control" id="perihal" name="perihal" value="{{ old('perihal') }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="kepada">Kepada</label>
                                    <input type="text" class="form-control" id="kepada" name="kepada" value="{{ old('kepada') }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="deskripsi">Deskripsi</label>
                                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="5" required>{{ old('deskripsi') }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="hari">Hari</label>
                                    <input type="text" class="form-control" id="hari" name="hari" value="{{ old('hari') }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="waktu">Waktu</label>
                                    <input type="time" class="form-control" id="waktu" name="waktu" value="{{ old('waktu') }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="tempat">Tempat</label>
                                    <input type="text" class="form-control" id="tempat" name="tempat" value="{{ old('tempat') }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="acara">Acara</label>
                                    <input type="text" class="form-control" id="acara" name="acara" value="{{ old('acara') }}" required>
                                </div>

                                <div class="form-group">
                                    <label for="gambar">Gambar (Opsional)</label>
                                    <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*,.pdf">
                                </div>
                                <div class="form-group">
                                    <label for="ttd_ketua">Tanda Tangan Ketua (Opsional)</label>
                                    <input type="file" class="form-control" id="ttd_ketua" name="ttd_ketua" accept="image/*,.pdf">
                                </div>





                                <button type="submit" class="btn btn-primary">Simpan</button>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
