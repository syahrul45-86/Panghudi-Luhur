@extends('frontend.layouts.master')

@section('content')

<section class="wsus__dashboard mt_90 xs_mt_70 pb_120 xs_pb_100">
    <div class="container">
        <div class="row">
            @include('frontend.instructor-dashboard.sidebar')

            <div class="col-xl-9 col-md-8 wow fadeInRight">
                <div class="wsus__dashboard_contant">
                    <div class="wsus__dashboard_contant_top">
                        <div class="wsus__dashboard_heading relative">
                            <h2>Catatan Arisan</h2>
                            <a href="{{ route('instructor.arisan.index') }}" class="btn btn-secondary float-end">Kembali</a>
                        </div>
                    </div>

                    <div class="wsus__dash_course_table">
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <div class="container">

                                        <!-- Form Tambah Tahun -->
                                        <h4 class="mt-4">Tambah Tahun</h4>
                                        <form action="{{ route('instructor.arisan.storeTahun') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="tahun" class="form-label">Tahun</label>
                                                <input type="number" class="form-control" name="tahun" required>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Tambah Tahun</button>
                                        </form>

                                        <!-- Form Tambah Tanggal -->
                                        <h4 class="mt-4">Tambah Tanggal</h4>
                                        <form action="{{ route('instructor.arisan.storeTanggal') }}" method="POST"  enctype="multipart/form-data">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="tahun_id">Tahun</label>
                                                <select name="tahun_id" class="form-control" required>
                                                    <option value="">-- Pilih Tahun --</option>
                                                    @foreach($tahuns as $tahun)
                                                        <option value="{{ $tahun->id }}">{{ $tahun->tahun }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="tanggal">Tanggal</label>
                                                <input type="date" class="form-control" name="tanggal" required>
                                            </div>
                                            <button type="submit" class="btn btn-success">Tambah Tanggal</button>
                                        </form>

                                    </div> <!-- End Container -->
                                </div>
                            </div>
                        </div>
                    </div> <!-- End wsus__dash_course_table -->
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
