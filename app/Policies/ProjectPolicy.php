<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
{
    use HandlesAuthorization;

    public function edit(User $user, Project $project)
    {
        if ($user->can('edit projects')) {
            return true;
        }

        if ($user->id === $project->leader_id) {
            return true;
        }

        return false;
    }

    public function view(User $user, Project $project)
    {
        if ($user->can('edit projects')) {
            return true;
        }

        if ($user->id === $project->leader_id || in_array($user->id, $project->projectUsers->pluck('user_id')->toArray())) {
            return true;
        }

        return false;
    }
}
