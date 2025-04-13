<?php

namespace App\Policies;

use App\Models\Experience;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ExperiencePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Experience  $experience
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Experience $experience)
    {
        return $user->id === $experience->profile->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Experience  $experience
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Experience $experience)
    {
        return $user->id === $experience->profile->user_id;
    }
}
