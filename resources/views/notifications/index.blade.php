@extends('layouts.app')

@section('title', 'Notifications')

@section('content')
    <div class="notifications-header">
        <h1>Notifications</h1>
        <form method="POST" action="{{ route('notifications.read_all') }}">
            @csrf
            <button class="button button-outline" type="submit">Mark all as read</button>
        </form>
    </div>

    @forelse ($notifications as $n)
        <div class="notifications-list">
        <div class="notification-card {{ $n->read_at ? 'notification-read' : 'notification-unread' }}">
            <div class="notification-icon">
                @if(str_contains($n->type, 'Reservation')) 📅
                @elseif(str_contains($n->type, 'Review')) ⭐
                @else 🔔
                @endif
            </div>

            <div class="notification-body">
                <p class="notification-title">{{ $n->data['title'] ?? 'Notification' }}</p>
                <p class="notification-message">{{ $n->data['message'] ?? '' }}</p>
            </div>

            <div class="notification-meta">
                <span class="notification-date">{{ $n->created_at->format('d M Y, H:i') }}</span>
                @if (!$n->read_at)
                    <form method="POST" action="{{ route('notifications.read', $n->id) }}">
                        @csrf
                        <button class="button button-outline" type="submit">Mark as read</button>
                    </form>
                @endif
            </div>
        </div>
        </div>
    @empty
        <div class="empty-state">
            <h3>🔔 No notifications yet</h3>
            <p>You're all caught up!</p>
        </div>
    @endforelse

    <div class="pagination-wrapper">
        {{ $notifications->links() }}
    </div>
@endsection