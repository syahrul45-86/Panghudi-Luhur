@extends('admin.layouts.master')

@section('content')
<div class="container">
    <h2>Edit Pengumuman</h2>

    <!-- Menampilkan pesan error -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.pengumuman.update', $pengumuman->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="judul">Judul</label>
            <input type="text" class="form-control" id="judul" name="judul" value="{{ old('judul', $pengumuman->judul) }}" required>
        </div>

        <div class="form-group">
            <label for="alamat">Alamat</label>
            <input type="text" class="form-control" id="alamat" name="alamat" value="{{ old('alamat', $pengumuman->alamat) }}" required>
        </div>

        <div class="form-group">
            <label for="nomor_surat">Nomor Surat</label>
            <input type="text" class="form-control" id="nomor_surat" name="nomor_surat" value="{{ old('nomor_surat', $pengumuman->nomor_surat) }}" required>
        </div>

        <div class="form-group">
            <label for="perihal">Perihal</label>
            <input type="text" class="form-control" id="perihal" name="perihal" value="{{ old('perihal', $pengumuman->perihal) }}" required>
        </div>

        <div class="form-group">
            <label for="kepada">Kepada</label>
            <input type="text" class="form-control" id="kepada" name="kepada" value="{{ old('kepada', $pengumuman->kepada) }}" required>
        </div>

        <div class="form-group">
            <label for="deskripsi">Deskripsi</label>
            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" required>{{ old('deskripsi', $pengumuman->deskripsi) }}</textarea>
        </div>

        <div class="form-group">
            <label for="hari">Hari</label>
            <input type="text" class="form-control" id="hari" name="hari" value="{{ old('hari', $pengumuman->hari) }}" required>
        </div>

        <div class="form-group">
            <label for="waktu">Waktu</label>
            <input type="time" class="form-control" id="waktu" name="waktu" value="{{ old('waktu', $pengumuman->waktu) }}" required>
        </div>

        <div class="form-group">
            <label for="tempat">Tempat</label>
            <input type="text" class="form-control" id="tempat" name="tempat" value="{{ old('tempat', $pengumuman->tempat) }}" required>
        </div>

        <div class="form-group">
            <label for="acara">Acara</label>
            <input type="text" class="form-control" id="acara" name="acara" value="{{ old('acara', $pengumuman->acara) }}" required>
        </div>

        <div class="form-group">
            <label for="gambar">template (Opsional)</label>
            <input type="file" class="form-control" id="gambar" name="gambar">
            @if ($pengumuman->gambar)
                <div class="mt-2">
                    <p>Gambar Saat Ini:</p>
                    <img src="{{ asset('uploads/' . $pengumuman->gambar) }}" alt="Gambar Pengumuman" width="200">
                </div>
            @endif
        </div>
          <div class="form-group">
                <label for="ttd_ketua">Gambar Tanda Tangan (Opsional)</label>
                <input type="file" class="form-control" id="ttd_ketua" name="ttd_ketua">
                @if ($pengumuman->ttd_ketua)
                    <div class="mt-2">
                        <p>Gambar Saat Ini:</p>
                        <img src="{{ asset('uploads/' . $pengumuman->ttd_ketua) }}" alt="Tanda Tangan Ketua" width="200">
                    </div>
                @endif
            </div>

        <button type="submit" class="btn btn-primary">Update Pengumuman</button>
    </form>
</div>
@endsection
