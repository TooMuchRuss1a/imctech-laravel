<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use App\Services\VkApiService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    public function admin(Request $request)
    {
        $errors = DB::table('errors')
            ->orderBy('id', 'DESC')
            ->get();

        $row = $errors->first();

        return view('admin.admin', ['errors' => $errors, 'keys' => (!empty($row)) ? array_keys(get_object_vars($row)) : null]);
    }


    public function users(Request $request)
    {

        $users = DB::table('users')
            ->select('id', 'login', 'name', 'agroup', 'email', 'email_verified_at')
            ->orderBy('id', 'DESC')
            ->get();

        $row = $users->first();

        return view('admin.users', ['users' => $users, 'keys' => (!empty($row)) ? array_keys(get_object_vars($row)) : null]);
    }

    public function view(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->socialData = [
            'vk' => VkApiService::getVkData($user->socials()->where('type', 'vk')->first()->link)
        ];

        return view('admin.view', ['user' => $user]);
    }

    public function events(Request $request)
    {

        $events = DB::table('events')
            ->orderBy('id', 'DESC')
            ->join('users as u1', 'events.updated_by', '=', 'u1.id')
            ->join('users as u2', 'events.created_by', '=', 'u2.id')
            ->select('events.id', 'events.name', 'events.register_until', 'events.updated_at', 'u1.login as updated_by', 'events.created_at', 'u2.login as created_by')
            ->get();

        $row = $events->first();

        return view('admin.events', ['events' => $events, 'keys' => (!empty($row)) ? array_keys(get_object_vars($row)) : null]);
    }

    public function eventCreate(Request $request)
    {
        return view('admin.eventCreate');
    }

    public function eventSave(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:events|max:255',
            'register_until' => 'required',
            'recaptcha' => 'recaptcha',
        ]);

        Event::create($validated);

        request()->session()->flash('status', 'Мероприятие успешно создано');
        return redirect()->route('admin.events');
    }
}
