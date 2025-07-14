@extends('frontend.layouts.master')

@section('content')
<!-- Breadcrumb -->
<section class="wsus__breadcrumb" style="background: url({{ asset(config('settings.site_breadcrumb')) }});">
    <div class="wsus__breadcrumb_overlay">
        <div class="container">
            <div class="row">
                <div class="col-12 wow fadeInUp">
                    <div class="wsus__breadcrumb_text">
                        <h1>Pengumuman</h1>
                        <ul>
                            <li><a href="{{ url('/') }}">Home</a></li>
                            <li>Pengumuman</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Pengumuman List -->
<section class="wsus__dashboard mt_90 xs_mt_70 pb_120 xs_pb_100">
    <div class="container">
        <div class="row">
            @auth
                <div class="col-12 wow fadeInRight">
                    <div class="wsus__dashboard_contant">
                        <div class="wsus__dashboard_contant_top mb-4">
                            <h4 class="mb-3">Daftar Pengumuman</h4>
                        </div>

                        <div class="row">
                            @forelse ($pengumuman as $p)
                                <div class="col-lg-4 col-md-6 mb-4">
                                    <div class="card h-100 shadow-sm border-0">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $p->judul }}</h5>
                                            <p class="card-text text-muted mb-2">
                                                <small><i class="fas fa-calendar-alt"></i> {{ $p->created_at->format('d M Y') }}</small>
                                            </p>
                                            <p class="card-text">{{ \Illuminate\Support\Str::limit(strip_tags($p->deskripsi), 100, '...') }}</p>
                                        </div>
                                        <div class="card-footer bg-white border-0">
                                            <a href="{{ route('pengumuman.cetak', $p->id) }}" target="_blank" class="btn btn-sm btn-primary w-100">
                                                <i class="fas fa-file-pdf"></i> Cetak PDF
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12">
                                    <div class="alert alert-warning text-center">
                                        Belum ada pengumuman.
                                    </div>
                                </div>
                            @endforelse
                        </div>

                        <!-- Pagination -->
                        <div class="mt-4">
                            {{ $pengumuman->links() }}
                        </div>
                    </div>
                </div>
            @else
                <div class="col-12">
                    <div class="alert alert-info mt-3 text-center" role="alert">
                        Tampilan Disembunyikan. <a href="{{ route('login') }}">Login</a> Harap Login!!!!!!!
                    </div>
                </div>
            @endauth
        </div>
    </div>
</section>
@endsection
