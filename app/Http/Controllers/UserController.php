<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Day;
use App\Models\Event;
use App\Models\User;
use App\Models\Project;
use App\Services\VkApiService;
use Illuminate\Http\Request;
use ProtoneMedia\Splade\Facades\Toast;

class UserController extends Controller
{

    public function home(Request $request)
    {
        return view('home');
    }

    public function pschool(Request $request)
    {
        $event = Event::findOrFail(4);
        $projects = Project::with(['publicProjectUsers.user.vk', 'projectLikes'])->withCount('projectLikes')->where('approved', '=', '1')->get()->sortByDesc('project_likes_count');
        if (cache('timetable')) {
            $days = Day::with('timelines')->orderBy('date')->get();
            $nextDay = $days->where('date', '>=', now())->first();
            $activeDay = !empty($nextDay) ? array_search($nextDay->date, $days->pluck('date')->toArray()) : 0;
            return view('pschool', compact('event', 'projects', 'days', 'activeDay'));
        }

        return view('pschool', compact('event', 'projects'));
    }

    public function psession(Request $request)
    {
        $students = Event::findOrFail(3)->activities()->count();

        return view('psession', ['students' => $students]);
    }

    public function service(Request $request)
    {
        return view('service.service');
    }

    public function activityCreate(Request $request)
    {
        $events = Event::where('register_until', '>', now())->orderBy('name')->get();

        return view('service.activityCreate', ['events' => $events]);
    }

    public function activitySave(Request $request)
    {
        $validated = $request->validate([
            'event_id' => 'required|register_actual',
        ]);

        $event = Event::where('id', $validated['event_id'])->firstOrFail();
        $vkApiService = new VkApiService();
        $chat_id = $event->conversation_id;
        if (!empty($chat_id)) {
            $chat_link = $vkApiService->getInviteLink($chat_id);
            request()->session()->flash('modal', $chat_link['link']);
        }

        if (!empty(Activity::where(['user_id' => auth()->id(), 'event_id' => $validated['event_id']])->first())) {
            request()->session()->flash('error', 'Вы уже записаны на мероприятие "' . $event->name .'"');
            Toast::title('Вы уже записаны на мероприятие "' . $event->name .'"')
                ->warning()
                ->autoDismiss(5);;
            return redirect()->route('service');
        }

        Activity::create([
            'user_id' => auth()->id(),
            'event_id' => $validated['event_id']
        ]);

        request()->session()->flash('status', 'Запись на мероприятие "' .$event->name .'" успешно создана');
        Toast::title('Запись на мероприятие "' .$event->name .'" успешно создана')
            ->success()
            ->autoDismiss(5);
        return redirect()->route('service');
    }

    public function privacy(Request $request)
    {
        return view('service.privacy');
    }

    public function profile(Request $request)
    {
        $vkApiService = new VkApiService();
        $user = User::with('vk', 'activities.event', 'userProjects.project')->findOrFail($request->user()->id);
        $user->socialData = [
            'vk' => (!empty($vk = $user->vk)) ? ((!empty($vk_data = $vkApiService->getVkDataViaLink($vk->link))) ? $vk_data[0] : null) : null,
        ];

        return view('service.profile', compact('user'));
    }
}
