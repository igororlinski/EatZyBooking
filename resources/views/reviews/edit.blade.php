@extends('layouts.app')

@section('title', 'Edit Review')

@section('content')
    <h1>Edit Review</h1>

    <form method="POST" action="{{ route('reviews.update', $review->id) }}" class="card-form">
        @csrf
        @method('PUT')

        <label>Rating</label>
        <div class="star-rating">
            @for ($i = 1; $i <= 5; $i++)
                <span class="star-btn {{ old('rating', $review->rating) >= $i ? 'active' : '' }}"
                    data-value="{{ $i }}">★</span>
            @endfor
            <input type="hidden" name="rating" value="{{ old('rating', $review->rating) }}">
        </div>
        @error('rating')
            <span class="error">{{ $message }}</span>
        @enderror

        <label>Comment</label>
        <textarea name="comment" required>{{ old('comment', $review->content) }}</textarea>
        @error('comment')
            <span class="error">{{ $message }}</span>
        @enderror

        <button type="submit" class="button">Save</button>
    </form>
@endsection