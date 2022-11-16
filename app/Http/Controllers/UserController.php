<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Day;
use App\Models\Event;
use App\Models\User;
use App\Services\VkApiService;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function home(Request $request)
    {
        return view('home');
    }

    public function pschool(Request $request)
    {
        $event = Event::findOrFail(4);
        if (cache('timetable')) {
            $days = Day::with('timelines')->orderBy('date')->get();
            $nextDay = $days->where('date', '>=', now())->first();
            $activeDay = !empty($nextDay) ? array_search($nextDay->date, $days->pluck('date')->toArray()) : 0;
            return view('pschool', compact('event', 'days', 'activeDay'));
        }

        return view('pschool', compact('event'));
    }

    public function psession(Request $request)
    {
        $students = Event::findOrFail(3)->activities()->count();

        return view('psession', ['students' => $students]);
    }

    public function analytics(Request $request) {
        $students = Activity::where('event_id', 2)->get()->count();
        $groups = array();
        $users = Event::findOrFail(2)
            ->join('activities', 'activities.event_id', '=', 'events.id')
            ->join('users', 'users.id', '=', 'activities.user_id')
            ->orderBy('agroup')
            ->get();

        foreach ($users as $user) {
            if (isset($groups[substr($user->agroup, 7)])) {
                $groups[substr($user->agroup, 7)]++;
            }
            else {
                $groups[substr($user->agroup, 7)] = 1;
            }
        }
        ksort($groups);

        return view('analytics', [
            'students' => $students,
            'groups' => $groups
        ]);
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
            request()->session()->flash('modal', ['title' => 'Остается только...', 'links' => ['Вступить в беседу ВК' => $chat_link['link'], 'Подписаться на телегам канал' => 'https://t.me/imctech']]);
        }

        if (!empty(Activity::where(['user_id' => auth()->id(), 'event_id' => $validated['event_id']])->first())) {
            request()->session()->flash('error', 'Вы уже записаны на мероприятие "' . $event->name .'"');
            return redirect()->route('service');
        }

        Activity::create([
            'user_id' => auth()->id(),
            'event_id' => $validated['event_id']
        ]);

        request()->session()->flash('status', 'Запись на мероприятие "' .$event->name .'" успешно создана');
        return redirect()->route('service');
    }

    public function privacy(Request $request)
    {
        return view('service.privacy');
    }

    public function profile(Request $request)
    {
        $vkApiService = new VkApiService();
        $user = User::with('vk', 'activities.event')->findOrFail($request->user()->id);
        $user->socialData = [
            'vk' => (!empty($vk = $user->vk)) ? ((!empty($vk_data = $vkApiService->getVkDataViaLink($vk->link))) ? $vk_data[0] : null) : null,
        ];

        return view('service.profile', compact('user'));
    }
}
