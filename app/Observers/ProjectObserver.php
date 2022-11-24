<?php

namespace App\Observers;

use App\Models\Project;
use App\Models\User;
use App\Notifications\NotifyProjectApproved;
use App\Notifications\NotifyProjectEdited;

class ProjectObserver
{
    public function updating(Project $project): void
    {
        if (!request()->user()->can('edit projects')) {
            $project->approved = 0;
            $admins = User::role('root')->get();
            foreach ($admins as $admin) {
                $admin->notify(new NotifyProjectEdited($project));
            }
        }

        if ($project->isDirty('approved') && $project->approved && $project->leader){
            $project->leader->notify(new NotifyProjectApproved($project));
        }
    }
}
