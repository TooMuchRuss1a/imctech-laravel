<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Social;
use App\Models\User;
use App\Services\SanitizerService;
use App\Services\VkApiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use OwenIt\Auditing\Models\Audit;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function audits(Request $request)
    {
        if (!$request->user()->can('view logs')) {
            abort(403);
        }

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
        if (!$request->user()->can('view logs')) {
            abort(403);
        }

        $api = DB::table('api_requests')
            ->orderBy('id', 'DESC')
            ->limit(100)
            ->get();

        $sanitizer = new SanitizerService();
        $api = $sanitizer->sanitizer($api, 'params');
        $api = $sanitizer->sanitizer($api, 'response');
        $row = $api->first();

        return view('service.admin.api', ['api' => $api, 'keys' => (!empty($row)) ? array_keys(get_object_vars($row)) : null]);
    }

    public function errors(Request $request)
    {
        if (!$request->user()->can('view logs')) {
            abort(403);
        }

        $errors = DB::table('errors')
            ->orderBy('id', 'DESC')
            ->limit(200)
            ->get();

        $sanitizer = new SanitizerService();
        $errors = $sanitizer->sanitizer($errors, 'data');
        $row = $errors->first();

        return view('service.admin.errors', ['errors' => $errors, 'keys' => (!empty($row)) ? array_keys(get_object_vars($row)) : null]);
    }

    public function dead_souls(Request $request)
    {
        if (!$request->user()->can('dead souls')) {
            abort(403);
        }

        $users = User::doesntHave('activities')->with('vk')->get()->except(1);

        return view('service.admin.dead_souls', compact('users'));
    }

    public function users(Request $request)
    {
        if (!$request->user()->can('view users')) {
            abort(403);
        }

        $users = DB::table('users')
            ->select('id', 'login', 'name', 'agroup', 'email', 'email_verified_at')
            ->orderBy('id', 'DESC')
            ->get();

        $row = $users->first();

        return view('service.admin.users.index', ['users' => $users, 'keys' => (!empty($row)) ? array_keys(get_object_vars($row)) : null]);
    }

    public function view(Request $request, $id)
    {
        if (!$request->user()->can('view users')) {
            abort(403);
        }

        $vkApiService = new VkApiService();

        $user = User::with('socials', 'activities.event', 'creator', 'updater')->findOrFail($id);
        $user->socialData = [
            'vk' => (!empty($vk = $user->socials->where('type', 'vk')->first())) ? ((!empty($vk_data = $vkApiService->getVkDataViaLink($vk->link))) ? $vk_data[0] : null) : null,
        ];

        return view('service.admin.users.view', ['user' => $user]);
    }

    public function userCreate(Request $request)
    {
        if (!$request->user()->can('create users')) {
            abort(403);
        }

        return view('service.admin.users.create');
    }

    public function userSave(Request $request)
    {
        if (!$request->user()->can('create users')) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'login' => 'required|string|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'agroup' => 'required',
            'password' => 'nullable|confirmed',
            'vk' => 'required|string|valid_vk'
        ]);

        $user = User::create([
            'login' => strtolower($validated['login']),
            'email' => strtolower($validated['email']),
            'name' => $validated['name'],
            'agroup' => $validated['agroup'],
            'password' => bcrypt($validated['password']),
        ]);

        $vkApiService = new VkApiService();
        $vk_id = $vkApiService->getVkDataViaLink($validated['vk'])[0]['id'];
        $user->socials()->create([
            'type' => 'vk',
            'link' => 'https://vk.com/id'.$vk_id
        ]);

        return redirect()->route('admin.users');
    }

    public function roles(Request $request)
    {
        if (!$request->user()->can('edit roles')) {
            abort(403);
        }

        $roles = Role::with('users', 'permissions')->get();

        $row = $roles->first();

        return view('service.admin.roles', ['roles' => $roles, 'keys' => (!empty($row)) ? array_keys(get_object_vars($row)) : null]);
    }

    public function roleCreate(Request $request)
    {
        if (!$request->user()->can('edit roles')) {
            abort(403);
        }

        return view('service.admin.roleCreate');
    }

    public function roleSave(Request $request)
    {
        if (!$request->user()->can('edit roles')) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|max:255',
            'recaptcha' => 'recaptcha',
        ]);

        $role = Role::create(['name' => $validated['name']]);
        $permission = Permission::firstOrCreate(['name' => 'view admin']);
        $role->givePermissionTo($permission);
        request()->session()->flash('status', 'Роль успешно создана');

        return redirect()->route('admin.roles');
    }

    public function userAdd(Request $request, $id)
    {
        if (!$request->user()->can('edit roles')) {
            abort(403);
        }

        $role = Role::findOrFail($id);
        $users = DB::table('users')
            ->whereNotNull('email_verified_at')
            ->orderBy('name')
            ->select('id', 'name')
            ->get();

        return view('service.admin.userAdd', ['users' => $users, 'role' => $role]);
    }

    public function userAddPost(Request $request, $id)
    {
        if (!$request->user()->can('edit roles')) {
            abort(403);
        }

        $role = Role::findOrFail($id);

        $validated = $request->validate([
            'user_id' => 'required|max:255|email_verified',
            'recaptcha' => 'recaptcha',
        ]);

        $user = User::findOrFail($validated['user_id']);
        $user->assignRole($role->name);
        request()->session()->flash('status', $user->login . ' выдана роль ' . $role->name);

        return redirect()->route('admin.roles');
    }

    public function permissionAdd(Request $request, $id)
    {
        if (!$request->user()->can('edit roles')) {
            abort(403);
        }

        $role = Role::findOrFail($id);

        return view('service.admin.permissionAdd', ['role' => $role]);
    }

    public function permissionAddPost(Request $request, $id)
    {
        if (!$request->user()->can('edit roles')) {
            abort(403);
        }

        $role = Role::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|max:255',
            'recaptcha' => 'recaptcha',
        ]);

        $permission = Permission::firstOrCreate(['name' => $validated['name']]);
        $role->givePermissionTo($permission);
        request()->session()->flash('status', $role->name . ' выдано право ' . $permission->name);

        return redirect()->route('admin.roles');
    }

    public function permissionRemove(Request $request, $id, $permission)
    {
        if (!$request->user()->can('edit roles')) {
            abort(403);
        }

        $role = Role::findOrFail($id);
        $permission = Permission::findOrFail($permission);

        $role->revokePermissionTo($permission);
        request()->session()->flash('status', $role->name . ' удалено право ' . $permission->name);

        return redirect()->route('admin.roles');
    }

    public function userRemove(Request $request, $id, $user)
    {
        if (!$request->user()->can('edit roles')) {
            abort(403);
        }

        $role = Role::findOrFail($id);
        $user = User::findOrFail($user);

        $user->removeRole($role);
        request()->session()->flash('status', $role->name . ' удалена роль ' . $role->name);

        return redirect()->route('admin.roles');
    }

    public function roleDelete(Request $request, $id)
    {
        if (!$request->user()->can('edit roles')) {
            abort(403);
        }

        $role = Role::findOrFail($id);
        if ($role->name == 'root') {
            request()->session()->flash('error', 'root нельзя удалить');
        }
        else {
            $role->delete();
            request()->session()->flash('status', 'Удалена роль ' . $role->name);
        }

        return redirect()->route('admin.roles');
    }

    public function edit(Request $request, $table, $id)
    {
        if (!$request->user()->can('edit')) {
            abort(403);
        }

        switch ($table) {
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
        if (!$request->user()->can('edit')) {
            abort(403);
        }

        switch ($table) {
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
                return redirect()->route('admin.users.view', ['id' => $item->user_id]);
            }
            return redirect()->route('admin.'.$table);
        }

        request()->session()->flash('error', 'Экземпляр не существует');
        return redirect()->route('service');
    }

    public function getLostUsers(Request $request)
    {
        if (!$request->user()->can('getlost')) {
            abort(403);
        }

        $events = Event::whereNotNull('conversation_id')->get();

        return view('service.admin.getLostUsers', ['events' => $events]);
    }

    public function getLostUsersPost(Request $request)
    {
        if (!$request->user()->can('getlost')) {
            abort(403);
        }

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
        /** Отключаем из-за отключения создания беседы ВК при создании мероприятия */
        abort(403, 'Отключено');
//        if (!$request->user()->can('remove chat user')) {
//            abort(403);
//        }
//
//        $vkApiService = new VkApiService();
//        $event = Event::where('conversation_id', $chat_id)->first();
//        if(!empty($event)) {
//            $members = $vkApiService->getConversationMembers($chat_id);
//            if (isset($members['profiles'])) {
//                array_multisort(array_column($members['profiles'], 'first_name'), SORT_ASC, $members['profiles']);
//                return view('service.admin.removeChatUser', ['users' => $members['profiles'], 'event' => $event]);
//            }
//            else request()->session()->flash('error', 'В беседе нет пользователей');
//        }
//        else request()->session()->flash('error', 'Мероприятие не существует');
//
//        return redirect()->route('admin.events');
    }

    public function removeChatUserPost(Request $request, $chat_id)
    {
        /** Отключаем из-за отключения создания беседы ВК при создании мероприятия */
        abort(403, 'Отключено');
//        if (!$request->user()->can('remove chat user')) {
//            abort(403);
//        }
//
//        $validated = $request->validate([
//            'user_id' => 'required',
//            'recaptcha' => 'recaptcha',
//        ]);
//
//        $vkApiService = new VkApiService();
//        if ($vkApiService->removeChatUser($chat_id, $validated['user_id']) == 1) {
//            $user = $vkApiService->getVkData([$validated['user_id']])[0];
//            $event = Event::where('conversation_id', $chat_id)->first();
//            request()->session()->flash('status', 'Пользователь ' . $user['first_name']. ' ' . $user['last_name'] . ' успешно исключен из беседы "'.$event->name.'"');
//        }
//        else request()->session()->flash('error', 'Возникла проблема при исключении пользователя');
//
//        return redirect()->route('service');
    }
}
