<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Role;
use App\Models\Social;
use App\Models\User;
use App\Services\SanitizerService;
use App\Services\VkApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

class AdminController extends Controller
{

    public function errors(Request $request)
    {
        $errors = DB::table('errors')
            ->orderBy('id', 'DESC')
            ->limit(200)
            ->get();

        $sanitizer = new SanitizerService();
        $errors = $sanitizer->sanitizer($errors, 'data');
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
        $vkApiService = new VkApiService();

        $user = User::findOrFail($id);
        $user->socialData = [
            'vk' => (!empty($vk = $user->socials()->where('type', 'vk')->first())) ? ((!empty($vk_data = $vkApiService->getVkDataViaLink($vk->link))) ? $vk_data[0] : null) : null,
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
            ->select('events.id', 'events.name', 'events.conversation_id', 'events.register_until', 'events.updated_at', 'u1.login as updated_by', 'events.created_at', 'u2.login as created_by')
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

        $event = Event::create($validated);
        request()->session()->flash('status', 'Мероприятие успешно создано');

        $vkApiService = new VkApiService();
        $chat_id = $vkApiService->createChat($event->name);

        if (!empty($chat_id)) {
            $chat_link = $vkApiService->getInviteLink($chat_id);
            $event->update(['conversation_id' => $chat_id]);
            if (!empty($chat_link)) {
                request()->session()->flash('modal', ['title' => 'Уведомление', 'links' => ['Беседа ВК создана' => $chat_link['link']]]);
            }
            else request()->session()->flash('error', 'Возникла проблема при получении ссылки на беседу ВК');
        }
        else request()->session()->flash('error', 'Возникла проблема при создании беседы ВК');

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

    public function edit(Request $request, $table, $id)
    {
        switch ($table) {
            case 'events':
                $item = Event::findOrFail($id);
                break;
            default:
                $item = null;
        }

        if (!empty($item)) {
            return view('service.admin.edit', ['item' => $item]);
        }

        request()->session()->flash('error', 'Экземпляр не существует');
        return redirect()->route('service');
    }

    public function editSave(Request $request, $table, $id)
    {
        switch ($table) {
            case 'events':
                $validated = $request->validate([
                    'name' => 'required|max:255',
                    'register_until' => 'required',
                    'conversation_id' => 'numeric|nullable',
                    'recaptcha' => 'recaptcha',
                ]);

                $item = Event::findOrFail($id);
                break;
            default:
                $validated = $item = null;
        }

        if (!empty($item)) {
            $item->update($validated);
            request()->session()->flash('status', 'Экземпляр обновлен');

            return redirect()->route('admin.'.$table);
        }

        request()->session()->flash('error', 'Экземпляр не существует');
        return redirect()->route('service');
    }

    public function getLostUsers(Request $request)
    {
        $events = Event::whereNotNull('conversation_id')->get();

        return view('service.admin.getLostUsers', ['events' => $events]);
    }

    public function getLostUsersPost(Request $request)
    {
        $validated = $request->validate([
            'event_id' => 'event_has_conversation',
            'recaptcha' => 'recaptcha',
        ]);

        $vk = Social::where(['user_id' => (auth()->id()), 'type' => 'vk'])->first();
        if (!empty($vk)) {
            $vkApiService = new VkApiService();
            if(!empty($vk_data = $vkApiService->getVkDataViaLink([$vk->link]))) {
                $admin_vk_id = $vk_data[0]['id'];

                $event = Event::findOrFail($validated['event_id']);
                $user_ids = $event->activities()->pluck('user_id');
                $users_vk_links = DB::table('users')
                    ->whereIn('users.id', $user_ids)
                    ->join('socials', 'users.id', '=', 'socials.user_id')
                    ->where('socials.type', '=','vk')
                    ->pluck('socials.link');

                if (!empty($conversation_users_data = $vkApiService->getConversationMembers($event->conversation_id))) {
                    $conversation_users = Arr::pluck($conversation_users_data['profiles'], 'id');
                    if (!empty($users_vk = $vkApiService->getVkDataViaLink($users_vk_links))) {
                        $users_vk_ids = Arr::pluck($users_vk, 'id');
                        $lost_users_id = (array_diff($users_vk_ids, $conversation_users));
                        $message = "Потеряшки \n". $event->name. " \n";
                        $lost_data = $vkApiService->getVkData($lost_users_id);
                        foreach ($lost_data as $data) {
                            $message .= "@id" . $data['id'] . "(" . $data['first_name'] . ' ' . $data['last_name'] . ") \n";
                        }
                        if(!empty($vkApiService->sendMsg($admin_vk_id, $message))) {
                            request()->session()->flash('status', 'Сообщение отправлено');
                        }
                        else request()->session()->flash('error', 'Необходимо разрешить боту отправлять вам сообщение - https://vk.com/imctechservice');

                    }
                    else request()->session()->flash('error', 'Проблема с доступом к профилям ВК');

                }
                else request()->session()->flash('error', 'Проблема с доступом к беседе');

            }
            else request()->session()->flash('error', 'Что-то не так с вашей ссылкой на ВК');

        }
        else request()->session()->flash('error', 'Ваш ВК не найден');

        return redirect()->route('service');
    }
}
