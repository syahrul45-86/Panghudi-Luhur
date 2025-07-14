@extends('frontend.layouts.master')

@section('content')
<style>
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    .table-responsive table {
        width: 100%;
        min-width: 600px;
    }
    .table-responsive th,
    .table-responsive td {
        white-space: nowrap;
        padding: 8px;
    }
    .table-responsive .btn {
        font-size: 12px;
        padding: 5px 8px;
    }
    .nama-anggota {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
</style>

<section class="wsus__dashboard mt_90 xs_mt_70 pb_120 xs_pb_100">
    <div class="container">
        <div class="row">
            @include('frontend.instructor-dashboard.sidebar')

            <div class="col-xl-9 col-md-8 wow fadeInRight">
                <div class="wsus__dashboard_contant">
                    <div class="wsus__dashboard_contant_top">
                        <div class="wsus__dashboard_heading relative">
                            <h2>Catatan Arisan Tahun {{ $tahun->tahun }}</h2>
                            <a href="{{ route('instructor.arisan.index') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </div>

                    {{-- FORM TAMBAH ANGGOTA --}}
                    <div class="mt-4">
                        <h5>Tambah Anggota Baru</h5>
                        <form action="{{ route('instructor.arisan.addAnggota') }}" method="POST" class="form-inline">
                            @csrf
                            <input type="hidden" name="tahun_id" value="{{ $tahun->id }}">
                            <div class="form-group">
                                <label for="user_id">Pilih User:</label>
                                <select name="user_id" id="user_id" class="form-control mx-2" required>
                                    <option value="">-- Pilih Anggota --</option>
                                    @foreach($users as $user)
                                        @if(!$anggota->contains('id', $user->id))
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary ml-2">Tambah</button>
                        </form>
                    </div>

                    {{-- Flash message --}}
                    @if(session('success'))
                        <div class="alert alert-success mt-2">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger mt-2">{{ session('error') }}</div>
                    @endif

                    <div class="wsus__dash_course_table table-responsive mt-4">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nama Anggota</th>
                                    @foreach($tahun->tanggal as $tgl)
                                        <th style="width: 30px; text-align: center;">
                                            {{ \Carbon\Carbon::parse($tgl->tanggal)->format('d M Y') }}
                                        </th>
                                    @endforeach
                                    <th>
                                        <form action="{{ route('instructor.arisan.deleteTanggal', $tgl->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">HapusTgl</button>
                                        </form>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($anggota as $user)
                                    <tr>
                                        <td>
                                            <div class="nama-anggota">
                                                <span>{{ $user->name }}</span>
                                                <form action="{{ route('instructor.arisan.removeAnggota') }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus anggota ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                                                    <input type="hidden" name="tahun_id" value="{{ $tahun->id }}">
                                                    <button type="submit" class="btn btn-danger btn-sm ml-2">Hapus</button>
                                                </form>
                                            </div>
                                        </td>
                                        @foreach($tahun->tanggal as $tgl)
                                            <td style="width: 30px; text-align: center;">
                                                <form action="{{ route('instructor.arisan.toggleChecklist') }}" method="POST" class="toggle-form">
                                                    @csrf
                                                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                                                    <input type="hidden" name="tanggal_id" value="{{ $tgl->id }}">
                                                    <input type="checkbox"
                                                           class="toggle-checklist"
                                                           {{ $user->arisans->where('tanggal_id', $tgl->id)->isNotEmpty() ? 'checked' : '' }}>
                                                </form>
                                            </td>
                                        @endforeach
                                        <td style="text-align: center;">
                                            {{ count($tahun->tanggal) - $user->arisans->count() }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div> {{-- End table --}}
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        const notyf = new Notyf();

        $('.toggle-checklist').on('change', function () {
            let form = $(this).closest('.toggle-form');
            let formData = form.serialize();
            let checkbox = $(this);

            checkbox.prop('disabled', true);

            $.ajax({
                url: form.attr('action'),
                type: form.attr('method'),
                data: formData,
                success: function (response) {
                    checkbox.prop('disabled', false);
                    if (response.status === 'success') {
                        notyf.success(response.message);
                        let row = checkbox.closest('tr');
                        let totalTanggal = {{ count($tahun->tanggal) }};
                        let checkedCount = row.find('.toggle-checklist:checked').length;
                        let uncheckedCount = totalTanggal - checkedCount;
                        row.find('td:last').text(uncheckedCount);
                    } else {
                        notyf.error('Terjadi kesalahan');
                    }
                },
                error: function () {
                    checkbox.prop('disabled', false);
                    notyf.error('Terjadi kesalahan, coba lagi.');
                }
            });

            return false;
        });
    });
</script>
@endsection
