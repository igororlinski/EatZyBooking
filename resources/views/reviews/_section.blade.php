@if ($errors->has('review'))
    <div class="alert alert-error">
        {{ $errors->first('review') }}
    </div>
@endif

@auth
    @if (Auth::user()->isCustomer())
        @php
            $alreadyReviewed = $restaurant->reviews()
                ->where('user_id', Auth::id())
                ->exists();
        @endphp

        @if (!$alreadyReviewed)
            <div class="review-form-wrapper">
                <form action="{{ route('reviews.store', $restaurant->id) }}" method="POST" class="card-form">
                    @csrf
                    <h2>Review this restaurant</h2>
                    
                    <label>Rating</label>
                    <div class="star-rating" id="star-rating">
                        @for ($i = 1; $i <= 5; $i++)
                            <span class="star-btn {{ old('rating', 5) >= $i ? 'active' : '' }}"
                                data-value="{{ $i }}">★</span>
                        @endfor
                        <input type="hidden" name="rating" id="rating-input" value="{{ old('rating', 5) }}">
                    </div>
                    @error('rating')
                        <span class="error">{{ $message }}</span>
                    @enderror

                    <label>Comment</label>
                    <textarea name="comment" required>{{ old('comment') }}</textarea>
                    @error('comment')
                        <span class="error">{{ $message }}</span>
                    @enderror

                    <button type="submit" class="button">Submit</button>
                </form>
            </div>
        @else
            <div class="alert alert-success">
                You have already reviewed this restaurant.
            </div>
        @endif
    @endif
@endauth

@foreach (
    $restaurant->reviews()
        ->with(['user', 'reply'])
        ->orderByDesc('created_at')
        ->get() as $review
)
    <div class="review-card">
        <div class="review-header">
            <div class="review-author">
                <div class="review-avatar">{{ strtoupper(substr($review->user->name ?? 'C', 0, 1)) }}</div>
                <div>
                    <strong class="review-name">{{ $review->user->name ?? 'Customer' }}</strong>
                    <small class="review-date">{{ \Carbon\Carbon::parse($review->created_at)->format('d M Y') }}</small>
                </div>
            </div>
            <div class="review-stars">
                @for ($i = 1; $i <= 5; $i++)
                    <span class="{{ $i <= $review->rating ? 'star-filled' : 'star-empty' }}">★</span>
                @endfor
            </div>
        </div>

        <p class="review-content">{{ $review->content }}</p>

        @if (Auth::check() && Auth::id() === $review->user_id)
            <div class="review-actions">
                <a class="button button-outline" href="{{ route('reviews.edit', $review->id) }}">Edit</a>
                <form action="{{ route('reviews.destroy', $review->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="button button-outline delete-button">Delete</button>
                </form>
            </div>
        @endif

        @if ($review->reply)
            <div class="review-reply">
                <div class="review-reply-header">
                    <span>🏪 Owner reply</span>
                    @if (Auth::check() && Auth::user()->isOwner() && Auth::id() === $restaurant->owner_id)
                        <div class="review-actions">
                            <a class="button button-outline" href="{{ route('replies.edit', $review->reply->id) }}">Edit</a>
                            <form action="{{ route('replies.destroy', $review->reply->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="button button-outline delete-button">Delete</button>
                            </form>
                        </div>
                    @endif
                </div>
                <p class="review-reply-content">{{ $review->reply->content }}</p>
            </div>
        @else
            @if (Auth::check() && Auth::user()->isOwner() && Auth::id() === $restaurant->owner_id)
                <form action="{{ route('replies.store', $review->id) }}" method="POST" class="review-reply-form">
                    @csrf
                    <textarea name="comment" placeholder="Write a reply..." required></textarea>
                    @error('comment')
                        <span class="error">{{ $message }}</span>
                    @enderror
                    <button type="submit" class="button">Reply</button>
                </form>
            @endif
        @endif
    </div>
@endforeach