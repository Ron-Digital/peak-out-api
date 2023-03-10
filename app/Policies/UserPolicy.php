<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserPolicy
{
    /**
     * Create a new policy instance.
     */
    public function isMyProfile(User $user)
    {
        return $user->id == Auth::user()->id;
    }
}
