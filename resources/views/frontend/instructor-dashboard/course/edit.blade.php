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
                                <h5>Edit Data Bendahara</h5>
                                <p>Update financial data here.</p>
                            </div>
                        </div>

                        <div class="wsus__dash_course_table">
                            <div class="row">
                                <div class="col-12">
                                    <div class="container">
                                        <h2 class="mb-3">Edit Laporan Keuangan</h2>

                                        @if(session('success'))
                                            <div class="alert alert-success">{{ session('success') }}</div>
                                        @endif

                                        <form action="{{ route('instructor.bendahara.update', $bendahara->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')

                                            <div class="mb-3">
                                                <label for="tanggal" class="form-label">Tanggal</label>
                                                <input type="date" name="tanggal" class="form-control" value="{{ $bendahara->tanggal }}" required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="keterangan" class="form-label">Keterangan</label>
                                                <input type="text" name="keterangan" class="form-control" value="{{ $bendahara->keterangan }}" required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="pemasukan" class="form-label">Pemasukan</label>
                                                <input type="number" name="pemasukan" class="form-control" value="{{ $bendahara->pemasukan }}" required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="pengeluaran" class="form-label">Pengeluaran</label>
                                                <input type="number" name="pengeluaran" class="form-control" value="{{ $bendahara->pengeluaran }}" required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="saldo_awal" class="form-label">Saldo Awal</label>
                                                <input type="number" name="saldo_awal" class="form-control" value="{{ $bendahara->saldo_awal }}" readonly>
                                            </div>

                                            <div class="mb-3">
                                                <label for="saldo_akhir" class="form-label">Saldo Akhir</label>
                                                <input type="number" name="saldo_akhir" class="form-control" value="{{ $bendahara->saldo_akhir }}" readonly>
                                            </div>

                                            <button type="submit" class="btn btn-primary">Update</button>
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
