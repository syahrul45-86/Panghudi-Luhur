@extends('admin.layouts.master')

@section('content')
<div class="container">
    <h1>Edit Card</h1>
    <form action="{{ route('admin.cards.update', $card->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="{{ $card->name }}" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="whatsapp">WhatsApp:</label>
            <input type="url" id="whatsapp" name="whatsapp" value="{{ $card->whatsapp }}" class="form-control">
        </div>

        <div class="form-group">
            <label for="instagram">Instagram:</label>
            <input type="url" id="instagram" name="instagram" value="{{ $card->instagram }}" class="form-control">
        </div>

        <div class="form-group">
            <label for="tiktok">TikTok:</label>
            <input type="url" id="tiktok" name="tiktok" value="{{ $card->tiktok }}" class="form-control">
        </div>

        <div class="form-group">
            <label for="image">Image:</label>
            <input type="file" id="image" name="image" class="form-control">
            @if ($card->image)
                <img src="{{ asset( $card->image) }}" alt="Card Image" width="150">
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
