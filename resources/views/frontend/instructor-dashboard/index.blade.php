@extends('frontend.layouts.master')

@section('content')
    <section class="wsus__dashboard mt_90 xs_mt_70 pb_120 xs_pb_100">
        <div class="container">
            <div class="row">
                @include('frontend.instructor-dashboard.sidebar')

                <div class="col-xl-9 col-md-8 wow fadeInRight">
                    <div class="wsus__dashboard_contant">


                        <div class="wsus__dash_course_table">
                            <div class="row">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <div class="container">
                                            <h2 class="mb-3">Dashboard Bendahara</h2>


                                            <div class="wsus__dash_course_table">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="table-responsive">
                                                            <div class="container">
                                                                @if(session('success'))
                                                                    <div class="alert alert-success">{{ session('success') }}</div>
                                                                @endif
                                                                <h2 class="mb-3">Laporan Keuangan Bendahara</h2>

                                                                <!-- Menampilkan Saldo Akhir Sebagai Saldo Awal -->
                                                                <div class="mb-3 d-flex justify-content-between align-items-center">
                                                                    <h5>Saldo Akhir: <span class="fw-bold text-primary">Rp {{ number_format($bendaharas->last()->saldo_akhir ?? 0, 2, ',', '.') }}</span></h5>

                                                                </div>

                                                                <table class="table table-striped table-hover text-center">
                                                                    <thead class="table-dark">
                                                                        <tr>
                                                                            <th>No</th>
                                                                            <th>Tanggal</th>
                                                                            <th>Keterangan</th>
                                                                            <th>Pemasukan</th>
                                                                            <th>Pengeluaran</th>
                                                                            <th>Saldo Akhir</th>
                                                                            <th></th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach($bendaharas as $key => $bendahara)
                                                                            <tr>
                                                                                <td>{{ $key + 1 }}</td>
                                                                                <td>{{ $bendahara->tanggal }}</td>
                                                                                <td>{{ $bendahara->keterangan }}</td>
                                                                                <td>Rp {{ number_format($bendahara->pemasukan, 2, ',', '.') }}</td>
                                                                                <td>Rp {{ number_format($bendahara->pengeluaran, 2, ',', '.') }}</td>
                                                                                <td>Rp {{ number_format($bendahara->saldo_akhir, 2, ',', '.') }}</td>
                                                                                <td>

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
