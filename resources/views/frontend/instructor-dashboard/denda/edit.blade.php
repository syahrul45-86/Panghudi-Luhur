@extends('frontend.layouts.master')

@section('content')
<section class="wsus__dashboard mt_90 xs_mt_70 pb_120 xs_pb_100">
    <div class="container">
        <div class="row">
            @include('frontend.instructor-dashboard.sidebar')

            <div class="col-xl-9 col-md-8 wow fadeInRight">
                <div class="wsus__dashboard_contant">
                    <div class="wsus__dashboard_contant_top">

                    </div>

                    <div class="wsus__dash_course_table">
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <div class="container">
                                        <h2 class="mb-3">Edit Data Denda Anggota</h2>
                                        <form action="{{ route('instructor.denda.update', $denda->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="mb-3">
                                                <label for="user_id" class="form-label">Nama Anggota</label>
                                                <select class="form-control" id="user_id" name="user_id" required>
                                                    <option value="">-- Pilih Anggota --</option>
                                                    @foreach($anggota as $a)
                                                        <option value="{{ $a->id }}" {{ $a->id == $denda->user_id ? 'selected' : '' }}>{{ $a->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="tanggal" class="form-label">Tanggal</label>
                                                <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ $denda->tanggal }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="keterangan" class="form-label">Keterangan</label>
                                                <textarea class="form-control" id="keterangan" name="keterangan">{{ $denda->keterangan }}</textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="jumlah" class="form-label">Jumlah</label>
                                                <input type="number" class="form-control" id="jumlah" name="jumlah" value="{{ $denda->jumlah }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="status" class="form-label">Status</label>
                                                <select class="form-control" id="status" name="status" required>
                                                    <option value="belum_lunas" {{ $denda->status == 'belum_lunas' ? 'selected' : '' }}>Belum Lunas</option>
                                                    <option value="lunas" {{ $denda->status == 'lunas' ? 'selected' : '' }}>Lunas</option>
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-success">Update</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
