{{-- @extends('frontend.layouts.master')

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
                                            @if(session('success'))
                                                <div class="alert alert-success">{{ session('success') }}</div>
                                            @endif
                                            <h2 class="mb-3">Laporan Keuangan Bendahara</h2>



                                            <!-- Bagian Saldo Awal -->
                                            <div class="mb-3 d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h5>Saldo Awal:</h5>

                                                </div>
                                                <a href="{{ route('instructor.bendahara.edit_saldo_awal') }}" class="btn btn-primary">Edit Saldo Awal</a>
                                            </div>

                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Tanggal</th>
                                                        <th>Keterangan</th>
                                                        <th>Pemasukan</th>
                                                        <th>Pengeluaran</th>
                                                        <th>Saldo Awal</th>
                                                        <th>Saldo Akhir</th>
                                                        <th>Aksi</th>
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
                                                            <td>
                                                                @if($key == 0)
                                                                    Rp {{ number_format($bendahara->saldo_awal, 2, ',', '.') }}
                                                                @endif
                                                            </td>
                                                            <td>Rp {{ number_format($bendahara->saldo_akhir, 2, ',', '.') }}</td>
                                                            <td>
                                                                <a href="{{ route('instructor.bendahara.edit', $bendahara->id) }}" class="btn btn-warning btn-sm">Edit</a>

                                                                <form action="{{ route('instructor.bendahara.destroy', $bendahara->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                                                </form>
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
    </section>
@endsection --}}
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
                                        <h2 class="mb-3">Laporan Keuangan Bendahara</h2>

                                        <!-- Menampilkan Saldo Akhir Sebagai Saldo Awal -->
                                        <div class="mb-3 d-flex justify-content-between align-items-center">
                                            <h5>Saldo Akhir: <span class="fw-bold text-primary">Rp {{ number_format($bendaharas->last()->saldo_akhir ?? 0, 2, ',', '.') }}</span></h5>
                                            <a href="{{ route('instructor.bendahara.edit_saldo_awal') }}" class="btn btn-primary">Edit Saldo Awal</a>
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
                                                    <th>Aksi</th>
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
                                                            <a href="{{ route('instructor.bendahara.edit', $bendahara->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                                            <form action="{{ route('instructor.bendahara.destroy', $bendahara->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                                            </form>
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
</section>
@endsection
