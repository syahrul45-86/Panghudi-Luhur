
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
                                        <h2 class="mb-3">Tambah data denda anggota</h2>
                                        <form action="{{ route('instructor.denda.store') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="user_id" class="form-label">Nama Anggota</label>
                                                <select class="form-control" id="user_id" name="user_id" required>
                                                    <option value="">-- Pilih Anggota --</option>
                                                    @foreach($anggota as $a)
                                                        <option value="{{ $a->id }}">{{ $a->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="tanggal" class="form-label">Tanggal</label>
                                                <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="keterangan" class="form-label">Keterangan</label>
                                                <textarea class="form-control" id="keterangan" name="keterangan"></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="jumlah" class="form-label">Jumlah</label>
                                                <input type="number" class="form-control" id="jumlah" name="jumlah" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="status" class="form-label">Status</label>
                                                <select class="form-control" id="status" name="status" required>
                                                    <option value="belum_lunas">Belum Lunas</option>
                                                    <option value="lunas">Lunas</option>
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-success">Simpan</button>
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
