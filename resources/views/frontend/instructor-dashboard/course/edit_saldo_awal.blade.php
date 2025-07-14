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
                                <h5>Edit Saldo Awal</h5>
                                <p>Ubah saldo awal keuangan bendahara.</p>
                            </div>
                        </div>

                        <div class="wsus__dash_course_table">
                            <div class="row">
                                <div class="col-12">
                                    <div class="container">
                                        <form action="{{ route('instructor.bendahara.update_saldo_awal') }}" method="POST">
                                            @csrf
                                            @method('PUT')

                                            <div class="mb-3">
                                                <label for="saldo_awal" class="form-label">Saldo Awal</label>
                                                <input type="number" name="saldo_awal" class="form-control" value="{{ old('saldo_awal', $saldo_awal) }}" required>
                                            </div>

                                            <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                                            <a href="{{ route('instructor.bendahara.index') }}" class="btn btn-secondary">Kembali</a>
                                        </form>
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
