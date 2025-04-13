<?php

namespace App\Policies;

use App\Models\Education;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EducationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Education  $education
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Education $education)
    {
        return $user->id === $education->profile->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Education  $education
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Education $education)
    {
        return $user->id === $education->profile->user_id;
    }
}
