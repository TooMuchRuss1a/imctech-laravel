<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectLike;
use Illuminate\Http\Request;

class ApiProjectController extends Controller
{

    public function likeProject(Request $request, $id)
    {
        if (!auth()->check())
            return 'login';

        if (!$project = Project::where('approved', '=', 1)->where('id', '=', $id)->first())
            return null;

        if ($projectLike = ProjectLike::where('user_id', '=', $request->user()->id)->where('project_id', '=', $project->id)->first()) {
            $projectLike->delete();

            return [
                'action' => 'disliked',
                'value' => $project->projectLikes->count()
            ];
        } else {
            ProjectLike::create([
                'user_id' => $request->user()->id,
                'project_id' => $project->id
            ]);

            return [
                'action' => 'liked',
                'value' => $project->projectLikes->count()
            ];
        }
    }
}
