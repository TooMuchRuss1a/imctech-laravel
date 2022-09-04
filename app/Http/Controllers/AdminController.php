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
use OwenIt\Auditing\Models\Audit;

class AdminController extends Controller
{
    public function audits(Request $request)
    {
        $audits = DB::table('audits')
            ->orderBy('id', 'DESC')
            ->join('users', 'audits.user_id', '=', 'users.id')
            ->addSelect('audits.id', 'users.login as user', 'audits.event')
            ->selectRaw('SUBSTRING(audits.auditable_type, 12) as auditable_type')
            ->addSelect('audits.auditable_id', 'audits.old_values', 'audits.new_values', 'audits.updated_at', 'audits.ip_address as ip')
            ->limit(200)
            ->get();

        $sanitizer = new SanitizerService();
        $audits = $sanitizer->sanitizer($audits, 'old_values');
        $audits = $sanitizer->sanitizer($audits, 'new_values');

        $row = $audits->first();

        return view('service.admin.audits', ['audits' => $audits, 'keys' => (!empty($row)) ? array_keys(get_object_vars($row)) : null]);
    }

    public function api(Request $request)
    {
        $api = DB::table('api_requests')
            ->orderBy('id', 'DESC')
            ->limit(200)
            ->get();

        $sanitizer = new SanitizerService();
        $api = $sanitizer->sanitizer($api, 'params');
        $api = $sanitizer->sanitizer($api, 'response');
        $row = $api->first();

        return view('service.admin.api', ['api' => $api, 'keys' => (!empty($row)) ? array_keys(get_object_vars($row)) : null]);
    }

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

        $user = User::with('socials', 'activities.event', 'creator', 'updater')->findOrFail($id);
        $user->socialData = [
            'vk' => (!empty($vk = $user->socials->where('type', 'vk')->first())) ? ((!empty($vk_data = $vkApiService->getVkDataViaLink($vk->link))) ? $vk_data[0] : null) : null,
        ];

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
            case 'roles':
                $item = Role::findOrFail($id);
                $params['users'] = DB::table('users')
                    ->whereNotNull('email_verified_at')
                    ->orderBy('users.name')
                    ->select('users.id', 'users.name')
                    ->get();
                break;
            case 'users':
                $item = User::findOrFail($id);
                break;
            case 'socials':
                $item = Social::findOrFail($id);
                $params['users'] = DB::table('users')
                    ->whereNotNull('email_verified_at')
                    ->orderBy('users.name')
                    ->select('users.id', 'users.name')
                    ->get();
                break;
            default:
                $item = null;
        }

        if (!empty($item)) {
            return view('service.admin.edit', ['item' => $item, 'params' => (isset($params)) ? $params : null]);
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
                $item = Event::find($id);
                break;
            case 'roles':
                $validated = $request->validate([
                    'name' => 'required|max:255',
                    'user_id' => 'required|max:255|email_verified',
                    'recaptcha' => 'recaptcha',
                ]);
                $item = Role::find($id);
                break;
            case 'users':
                $validated = $request->validate([
                    'name' => 'required|max:255',
                    'agroup' => 'required|max:255',
                    'recaptcha' => 'recaptcha',
                ]);
                $item = User::find($id);
                break;
            case 'socials':
                $validated = $request->validate([
                    'type' => 'required|max:255',
                    'link' => 'required|max:255',
                    'recaptcha' => 'recaptcha',
                ]);
                $item = Social::find($id);
                break;
            default:
                $validated = $item = null;
        }

        if (!empty($item)) {
            if ($table == 'users') {
                Audit::create([
                    'user_type' => 'App\Models\User',
                    'user_id' => auth()->id(),
                    'event' => 'updated',
                    'auditable_type' => 'App\Models\User',
                    'auditable_id' => $item->id,
                    'old_values' => ['name' => $item->name, 'agroup' => $item->agroup],
                    'new_values' => ['name' => $validated['name'], 'agroup' => $validated['agroup']],
                    'url' => request()->getRequestUri()
                ]);
            }
            $item->update($validated);
            request()->session()->flash('status', 'Экземпляр обновлен');

            if (in_array($table, ['socials'])) {
                return redirect()->route('admin.view', ['id' => $item->user_id]);
            }
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
                    if (isset($conversation_users_data['profiles'])) {
                        $conversation_users = Arr::pluck($conversation_users_data['profiles'], 'id');
                        if (!empty($users_vk = $vkApiService->getVkDataViaLink($users_vk_links))) {
                            $users_vk_ids = Arr::pluck($users_vk, 'id');
                            $lost_users_id = (array_diff($users_vk_ids, $conversation_users));
                            $message = "Потеряшки \n" . $event->name . " \n";
                            $lost_data = $vkApiService->getVkData($lost_users_id);
                            foreach ($lost_data as $data) {
                                $message .= "@id" . $data['id'] . "(" . $data['first_name'] . ' ' . $data['last_name'] . ") \n";
                            }
                            if (!empty($vkApiService->sendMsg($admin_vk_id, $message))) {
                                request()->session()->flash('status', 'Сообщение отправлено');
                            } else request()->session()->flash('error', 'Необходимо разрешить боту отправлять вам сообщение - https://vk.com/imctechservice');

                        } else request()->session()->flash('error', 'Проблема с доступом к профилям ВК');
                    } else request()->session()->flash('error', 'В беседе нет пользователей');

                }
                else request()->session()->flash('error', 'Проблема с доступом к беседе');

            }
            else request()->session()->flash('error', 'Что-то не так с вашей ссылкой на ВК');

        }
        else request()->session()->flash('error', 'Ваш ВК не найден');

        return redirect()->route('service');
    }

    public function removeChatUser(Request $request, $chat_id)
    {
        $vkApiService = new VkApiService();
        $event = Event::where('conversation_id', $chat_id)->first();
        if(!empty($event)) {
            $members = $vkApiService->getConversationMembers($chat_id);
            if (isset($members['profiles'])) {
                array_multisort(array_column($members['profiles'], 'first_name'), SORT_ASC, $members['profiles']);
                return view('service.admin.removeChatUser', ['users' => $members['profiles'], 'event' => $event]);
            }
            else request()->session()->flash('error', 'В беседе нет пользователей');
        }
        else request()->session()->flash('error', 'Мероприятие не существует');

        return redirect()->route('admin.events');
    }

    public function removeChatUserPost(Request $request, $chat_id)
    {
        $validated = $request->validate([
            'user_id' => 'required',
            'recaptcha' => 'recaptcha',
        ]);

        $vkApiService = new VkApiService();
        if ($vkApiService->removeChatUser($chat_id, $validated['user_id']) == 1) {
            $user = $vkApiService->getVkData([$validated['user_id']])[0];
            $event = Event::where('conversation_id', $chat_id)->first();
            request()->session()->flash('status', 'Пользователь ' . $user['first_name']. ' ' . $user['last_name'] . ' успешно исключен из беседы "'.$event->name.'"');
        }
        else request()->session()->flash('error', 'Возникла проблема при исключении пользователя');

        return redirect()->route('service');
    }
}
