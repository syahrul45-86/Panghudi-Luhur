{{-- @extends('frontend.layouts.master')

@section('content')
{{-- <div class="container">
    <div class="row">
        @forelse ($cards as $card)
            <div class="col-md-4">
                <div class="card">
                    <img src="{{ asset('storage/' . $card->image) }}" alt="{{ $card->name }}" class="card__image">
                    <p class="card__name">{{ $card->name }}</p>
                    <div class="grid-container">
                        <div class="grid-child-posts">
                            {{ $card->posts }} Post
                        </div>
                        <div class="grid-child-followers">
                            {{ $card->likes }} Likes
                        </div>
                    </div>
                    <ul class="social-icons">
                        @if ($card->whatsapp)
                            <li><a href="{{ $card->whatsapp }}" target="_blank"><i class="fa fa-whatsapp"></i></a></li>
                        @endif
                        @if ($card->instagram)
                            <li><a href="{{ $card->instagram }}" target="_blank"><i class="fa fa-instagram"></i></a></li>
                        @endif
                        @if ($card->tiktok)
                            <li><a href="{{ $card->tiktok }}" target="_blank"><i class="fa fa-tiktok"></i></a></li>
                        @endif
                    </ul>
                    <button class="btn draw-border">Follow</button>
                    <button class="btn draw-border">Message</button>
                </div>
            </div>
        @empty
            <p>Tidak ada card untuk ditampilkan.</p>
        @endforelse
    </div>
</div> --}}
{{-- @endsection --}} --}}
<h1>halaman card</h1>
