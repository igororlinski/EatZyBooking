<?php

namespace App\Policies;

use App\Models\Reply;
use App\Models\Review;
use App\Models\User;

class ReplyPolicy
{
    public function create(User $user, Review $review): bool
    {
        return $user->isOwner() && $review->restaurant->owner_id === $user->id;
    }

    public function view(?User $user, Reply $reply): bool
    {
        return true;
    }

    public function update(User $user, Reply $reply): bool
    {
        return $user->id === $reply->user_id;
    }

    public function delete(User $user, Reply $reply): bool
    {
        return $user->id === $reply->user_id;
    }
}
