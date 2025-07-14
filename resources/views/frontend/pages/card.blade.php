@extends('frontend.layouts.master')

@section('content')
<div class="container-card">
    <div class="row">
        @auth
            @forelse ($cards as $card)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="{{ asset($card->image) }}" alt="{{ $card->name }}" class="card__image">
                        <p class="card__name">{{ $card->name }}</p>
                        <div class="grid-container">

                        </div>
                        <ul class="social-icons">
                            @if ($card->whatsapp)
                                <li><a href="{{ $card->whatsapp }}" target="_blank"><i class="fa fa-whatsapp"></i></a></li>
                            @endif
                            @if ($card->instagram)
                                <li><a href="{{ $card->instagram }}" target="_blank"><i class="fa fa-instagram"></i></a></li>
                            @endif
                            @if ($card->tiktok)
                                <li><a href="{{ $card->tiktok }}" target="_blank"><i class="fab fa-tiktok"></i></a></li>
                            @endif
                        </ul>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p>Tidak ada card untuk ditampilkan.</p>
                </div>
            @endforelse
        @else
            <div class="col-12">
                <div class="alert alert-info mt-3 text-center" role="alert">
                    Tampilan Disembunyikan  <a href="{{ route('login') }}">Login</a> Harap Login!!!!!!!
                </div>
            </div>
        @endauth
    </div>
</div>
@endsection
