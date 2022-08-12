<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Role;
use App\Models\User;
use App\Services\VkApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    protected function sanitizer($object, $column) {
        foreach ($object as $row) {
            if (empty($row->$column)) continue;
            $array = json_decode($row->$column);
            foreach ($array as $key => $value) {
                $array->$key = htmlspecialchars($value);
            }
            $row->$column = json_encode($array);
        }
        return $object;
    }

    public function admin(Request $request)
    {
        return view('service.admin.admin');
    }

    public function errors(Request $request)
    {
        $errors = DB::table('errors')
            ->orderBy('id', 'DESC')
            ->limit(200)
            ->get();

        $errors = $this->sanitizer($errors, 'data');
        $row = $errors->first();

        return view('service.admin.errors', ['errors' => $errors, 'keys' => (!empty($row)) ? array_keys(get_object_vars($row)) : null]);
    }


    public function users(Request $request)
    {

        $users = DB::table('users')
            ->select('id', 'login', 'name', 'agroup', 'email', 'email_verified_at')
            ->orderBy('id', 'DESC')
            ->get();

        $row = $users->first();

        return view('service.admin.users', ['users' => $users, 'keys' => (!empty($row)) ? array_keys(get_object_vars($row)) : null]);
    }

    public function view(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->socialData = [
            'vk' => (!empty($vk = $user->socials()->where('type', 'vk')->first())) ? VkApiService::getVkData($vk->link) : null,
        ];
        $user->activities = DB::table('activities')
            ->where('user_id', '=', $user->id)
            ->join('events', 'activities.event_id', '=', 'events.id')
            ->select('events.name')
            ->get();

        return view('service.admin.view', ['user' => $user]);
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

        return view('service.admin.events', ['events' => $events, 'keys' => (!empty($row)) ? array_keys(get_object_vars($row)) : null]);
    }

    public function eventCreate(Request $request)
    {
        return view('service.admin.eventCreate');
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

    public function roles(Request $request)
    {
        $roles = DB::table('roles')
            ->join('users as u1', 'roles.user_id', '=', 'u1.id')
            ->join('users as u2', 'roles.created_by', '=', 'u2.id')
            ->join('users as u3', 'roles.updated_by', '=', 'u3.id')
            ->orderBy('roles.id', 'DESC')
            ->select('roles.id as id', 'roles.name as role', 'u1.login as user', 'roles.created_at as created_at', 'u2.login as created_by', 'roles.updated_at as updated_at', 'u3.login as updated_by')
            ->get();

        $row = $roles->first();

        return view('service.admin.roles', ['roles' => $roles, 'keys' => (!empty($row)) ? array_keys(get_object_vars($row)) : null]);
    }

    public function roleCreate(Request $request)
    {
        $users = DB::table('users')
            ->whereNotNull('email_verified_at')
            ->leftjoin('roles', 'roles.user_id', '=', 'users.id')
            ->whereNull('roles.id')
            ->orderBy('users.name')
            ->select('users.id', 'users.name')
            ->get();

        return view('service.admin.roleCreate', ['users' => $users]);
    }

    public function roleSave(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|unique:roles|max:255|email_verified',
            'name' => 'required|max:255',
            'recaptcha' => 'recaptcha',
        ]);

        Role::create($validated);

        request()->session()->flash('status', 'Роль успешно выдана');
        return redirect()->route('admin.roles');
    }
}
