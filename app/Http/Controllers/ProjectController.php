<?php

namespace App\Http\Controllers;

use App\Models\Day;
use App\Models\Event;
use App\Models\Project;
use App\Models\ProjectUser;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request) {
        $projects = Project::withCount('projectUsers')->orderBy('id', 'desc')->get();

        return view('service.projects.index', compact('projects'));
    }

    public function join(Request $request, $id) {
        $project = Project::findOrFail($id);
        if (!ProjectUser::where('user_id', '=', $request->user()->id)->where('project_id', '=', $project->id)->first()) {
            ProjectUser::create([
                'user_id' => $request->user()->id,
                'project_id' => $project->id
            ]);
            request()->session()->flash('status', 'Вы присоединились к проекту. Получить доступ к своим проектам можно на странице "Профиль"');
        }
        else
            request()->session()->flash('error', 'Вы уже состоите в проекте. Получить доступ к своим проектам можно на странице "Профиль"');

        return redirect()->route('service.projects.view', ['id' => $project->id]);
    }

    public function exit(Request $request, $id) {
        $project = Project::findOrFail($id);
        if ($projectUser = ProjectUser::where('user_id', '=', $request->user()->id)->where('project_id', '=', $project->id)->first()) {
            $projectUser->delete();
            request()->session()->flash('status', 'Вы покинули проект');
        }
        else
            request()->session()->flash('error', 'Вы не состоите в проекте');

        return redirect()->route('service.projects');
    }

    public function removeUser(Request $request, $id, $user_id) {
        $project = Project::findOrFail($id);
        if (!$request->user()->can('edit', $project))
            return redirect()->route('service.projects')->withErrors('У вас нет прав на удаление участников');

        if ($projectUser = ProjectUser::where('user_id', '=', $user_id)->where('project_id', '=', $project->id)->first()) {
            $projectUser->delete();
            request()->session()->flash('status', 'Участник выгнан');
        }
        else
            request()->session()->flash('error', 'Участника нет в проекте');

        return redirect()->route('service.projects.view', ['id' => $project->id]);
    }

    public function view(Request $request, $id)
    {
        $project = Project::with('leader', 'projectUsers.user', 'projectLikes')->findOrFail($id);
        if (!$request->user()->can('view', $project))
            return redirect()->route('service.projects')->withErrors('У вас нет прав для просмотра проекта');

        return view('service.projects.view', compact('project'));
    }

    public function toggleAgreement(Request $request, $id) {
        $project = Project::findOrFail($id);
        $projectUser = ProjectUser::where('user_id', '=', $request->user()->id)->where('project_id', '=', $project->id)->first();
        if ($projectUser == null) {
            return redirect()->route('service.projects')->withErrors('Вы не состоите в проекте');
        }
        $projectUser->update([
            'agreement' => !$projectUser->agreement
        ]);
        request()->session()->flash('status', 'Вы согласились на распространение своих персональных данных неограниченному кругу лиц на сайте imctech.ru');

        return redirect()->route('service.projects.view', ['id' => $project->id]);
    }

    public function publish(Request $request, $id)
    {
        $project = Project::findOrFail($id);
        if (!$request->user()->can('edit', $project))
            return redirect()->route('service.projects')->withErrors('У вас нет прав на подготовку проекта к публикации');

        return view('service.projects.publish', compact('project'));
    }

    public function publishPost(Request $request, $id)
    {
        $project = Project::with('publicProjectUsers.user.vk')->findOrFail($id);
        if (!$request->user()->can('edit', $project))
            return redirect()->route('service.projects')->withErrors('У вас нет прав на подготовку проекта к публикации');

        $validated = $request->validate([
            'name' => 'required|unique:projects,name,'.$project->id,
            'subname' => 'required',
            'text' => 'required', 'not_regex:<\s*a[^>]*>(.*?)<\s*/\s*a>',
            'image_d' => 'mimes:jpeg,jpg,png|max:10000' . ($project->image_d) ? '' : '|required',
            'image_m' => 'mimes:jpeg,jpg,png|max:10000' . ($project->image_m) ? '' : '|required',
        ]);
        if (isset($validated['image_d']))
            $imageNameD = hash('sha256', time().$validated['image_d']).'.'.$validated['image_d']->extension();

        if (isset($validated['image_m']))
            $imageNameM = hash('sha256', time().$validated['image_m']).'.'.$validated['image_m']->extension();

        if ($request->input('Submit') == 'show') {
            $validated['image_d'] = isset($validated['image_d']) ? '/img/temp/'.$validated['image_d']->move(public_path('img/temp'), $imageNameD)->getFilename() : $project->image_d;
            $validated['image_m'] = isset($validated['image_m']) ? '/img/temp/'.$validated['image_m']->move(public_path('img/temp'), $imageNameM)->getFilename() : $project->image_m;
            $testProject = Project::make($validated);
            $testProject->publicProjectUsers = $project->publicProjectUsers;
            $event = Event::findOrFail(4);
            $projects = Project::with(['publicProjectUsers.user.vk', 'projectLikes'])->withCount('projectLikes')->where('approved', '=', '1')->get()->except($id)->sortByDesc('project_likes_count');
            $projects->add($testProject);
            if (cache('timetable')) {
                $days = Day::with('timelines')->orderBy('date')->get();
                $nextDay = $days->where('date', '>=', now())->first();
                $activeDay = !empty($nextDay) ? array_search($nextDay->date, $days->pluck('date')->toArray()) : 0;
                return view('pschool', compact('event', 'projects', 'days', 'activeDay'));
            }

            return view('pschool', compact('event', 'projects'));
        }
        if (isset($validated['image_d']))
            $validated['image_d'] = '/img/projects/'.$validated['image_d']->move(public_path('img/projects'), $imageNameD)->getFilename();
        if (isset($validated['image_m']))
            $validated['image_m'] = '/img/projects/'.$validated['image_m']->move(public_path('img/projects'), $imageNameM)->getFilename();
        $project->update($validated);
        request()->session()->flash('status', 'Отправлено на рассмотрение');

        return redirect()->route('service.projects.view', ['id' => $id]);
    }
}
