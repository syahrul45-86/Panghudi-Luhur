@extends('frontend.layouts.master')

@section('content')
<section class="wsus__dashboard mt_90 xs_mt_70 pb_120 xs_pb_100">
    <div class="container">
        <div class="row">
            @include('frontend.instructor-dashboard.sidebar')

            <div class="col-xl-9 col-md-8 wow fadeInRight">
                <div class="wsus__dashboard_contant">
                    <div class="wsus__dashboard_contant_top">
                        <div class="wsus__dashboard_heading relative d-flex justify-content-between align-items-center">
                            <div>
                                <h5> Catatan Denda</h5>
                                <p>Manage your financial data here.</p>
                                <a class="common_btn" href="{{ route('instructor.denda.create') }}">+ Add Data</a>

                            </div>
                        </div>

                    </div>

                    <div class="position-relative w-50">
                        <input type="text" id="search" class="form-control" placeholder="Cari nama anggota">
                        <div class="menu_search_btn position-absolute top-50 end-0 translate-middle-y" >
                            <img src="{{ asset('frontend/assets/images/search_icon.png') }}" alt="Search" class="img-fluid">
                        </div>
                    </div>
                    <div class="wsus__dash_course_table">
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <div class="container">
                                        <div class="mb-3 d-flex justify-content-between align-items-center">
                                            <a class="common_btn " href="{{ route('instructor.denda.print_unpaid') }}" target="_blank">Cetak pdf</a>
                                        </div>
                                        <table class="table table-striped table-hover text-center">
                                            <thead class="table-dark">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama</th>
                                                    <th>Tanggal</th>
                                                    <th>Keterangan</th>
                                                    <th>Jumlah</th>
                                                    <th>Status</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody id="dendaTableBody">
                                                @foreach($dendas as $key => $denda)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $denda->anggota->name }}</td>
                                                    <td>{{ date('d-m-Y', strtotime($denda->tanggal)) }}</td>
                                                    <td>{{ $denda->keterangan }}</td>
                                                    <td>Rp {{ number_format($denda->jumlah, 2) }}</td>
                                                    <td>
                                                        <span class="badge {{ $denda->status == 'lunas' ? 'bg-success' : 'bg-danger' }}">
                                                            {{ ucfirst(str_replace('_', ' ', $denda->status)) }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('instructor.denda.edit', $denda->id) }}" class="btn btn-warning">Edit</a>
                                                        <form action="{{ route('instructor.denda.destroy', $denda->id) }}" method="POST" style="display:inline-block;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin hapus denda ini?')">Hapus</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <div id="noResults" class="text-center text-danger d-none">Data tidak ditemukan</div>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function(){
        $('#search').on('keyup', function(){
            let query = $(this).val();
            $.ajax({
                url: "{{ route('instructor.denda.search') }}",
                type: "GET",
                data: { search: query },
                success: function(data){
                    $('#dendaTableBody').html(data);
                    if (data.trim() === '') {
                        $('#noResults').removeClass('d-none');
                    } else {
                        $('#noResults').addClass('d-none');
                    }
                }
            });
        });
    });
</script>
@endsection
