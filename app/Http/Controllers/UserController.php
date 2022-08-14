<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Event;
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
        $students = Event::findOrFail(2)->activities()->count();

        return view('pschool', ['students' => $students]);
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
            'recaptcha' => 'recaptcha',
        ]);

        $event = Event::where('id', $validated['event_id'])->first();
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
}
