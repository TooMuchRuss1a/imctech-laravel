<?php

namespace App\Http\Controllers;

use App\Models\Day;
use App\Models\Event;
use App\Models\Project;
use App\Models\User;
use App\Services\ProjectService;
use Illuminate\Http\Request;

class AdminProjectController extends Controller
{
    public function index(Request $request) {
        $projects = Project::with(['creator', 'updater', 'leader'])->withCount('projectLikes')->orderBy('id', 'desc')->get();

        return view('service.admin.projects.index', compact('projects'));
    }

    public function create(Request $request) {
        return view('service.admin.projects.create');
    }

    public function store(Request $request) {
        $projects = ProjectService::getProjectsFromPostData($request->post());
        list($projects, $errors) = ProjectService::validateProjects($projects);
        foreach ($projects as $project) {
            Project::create($project);
        }
        if (count($projects) != 0)
            $request->session()->flash('status', 'Успешно создано');

        return redirect(route('admin.projects'))->withErrors($errors);
    }

    public function edit(Request $request, $id) {
        $project = Project::findOrFail($id);
        $users = User::whereNotNull('email_verified_at')->orderBy('name')->get()->except(1);

        return view('service.admin.projects.edit', compact('project', 'users'));
    }

    public function update(Request $request, $id) {
        $project = Project::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|unique:projects,name,'.$project->id,
            'description' => 'nullable|string',
            'leader_id' => 'nullable|int|email_verified',
            'approved' => 'required',
        ]);
        $validated['leader_id'] = $validated['leader_id'] ?? null;
        $validated['description'] = $validated['description'] ?? null;
        $project->update($validated);
        $request->session()->flash('status', 'Успешно обновлено');

        return redirect(route('admin.projects'));
    }

    public function delete(Request $request, $id) {
        Project::findOrFail($id)->delete();
        $request->session()->flash('status', 'Успешно удалено');

        return redirect()->route('admin.projects');
    }

    public function view(Request $request, $id) {
        $project = Project::with('updater', 'creator', 'leader', 'projectUsers', 'projectLikes.user')->findOrFail($id);

        return view('service.admin.projects.view', compact('project'));
    }

    public function testView(Request $request, $id) {
        $project = Project::findOrFail($id);
        if ($project->text == null || $project->subname == null || $project->name == null || $project->image_m == null || $project->image_d == null) {
            return redirect()->route('admin.projects.view', ['id' => $project->id])->withErrors('Проект еще не подготовлен');
        }

        $projects = Project::with(['publicProjectUsers.user.vk', 'projectLikes'])->withCount('projectLikes')->where('approved', '=', '1')->get()->except($id)->sortByDesc('project_likes_count');
        $projects->add($project);
        $event = Event::findOrFail(4);
        if (cache('timetable')) {
            $days = Day::with('timelines')->orderBy('date')->get();
            $nextDay = $days->where('date', '>=', now())->first();
            $activeDay = !empty($nextDay) ? array_search($nextDay->date, $days->pluck('date')->toArray()) : 0;
            return view('pschool', compact('event', 'projects', 'days', 'activeDay'));
        }

        return view('pschool', compact('event', 'projects'));
    }
}
