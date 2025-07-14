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
                            <h5>Bendahara</h5>
                            <p>Manage your financial data here.</p>
                            <a class="common_btn" href="{{ route('instructor.bendahara.create') }}">+ Add Data</a>
                        </div>
                    </div>

                    <div class="wsus__dash_course_table">
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <div class="container">
                                        <h2 class="mb-3">Tambah Data Keuangan Bendahara</h2>

                                        @if($saldo_awal === null || $saldo_awal === 0)
                                            <!-- Form untuk input saldo awal -->
                                            <form action="{{ route('instructor.bendahara.storeSaldoAwal') }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="saldo_awal" class="form-label">Saldo Awal</label>
                                                    <input type="number" name="saldo_awal" class="form-control" required>
                                                </div>
                                                <button type="submit" class="btn btn-success">Simpan</button>
                                            </form>
                                        @else
                                            <!-- Form untuk input data keuangan -->
                                            <form action="{{ route('instructor.bendahara.storeKeuangan') }}" method="POST">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="tanggal" class="form-label">Tanggal</label>
                                                    <input type="date" name="tanggal" class="form-control" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="keterangan" class="form-label">Keterangan</label>
                                                    <input type="text" name="keterangan" class="form-control" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="pemasukan" class="form-label">Pemasukan</label>
                                                    <input type="number" name="pemasukan" class="form-control">
                                                </div>

                                                <div class="mb-3">
                                                    <label for="pengeluaran" class="form-label">Pengeluaran</label>
                                                    <input type="number" name="pengeluaran" class="form-control">
                                                </div>

                                                <button type="submit" class="btn btn-success">Simpan</button>
                                            </form>
                                        @endif

                                        <a href="{{ route('instructor.bendahara.index') }}" class="btn btn-secondary mt-3">Kembali</a>
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
