<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;


    public function __construct()
    {
        //
    }


    public function update(User $signedInUser, User $user)
    {
        return $signedInUser->id === $user->id;
    }
}
