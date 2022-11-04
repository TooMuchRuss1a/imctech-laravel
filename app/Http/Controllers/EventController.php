<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Services\VkApiService;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->user()->can('view events')) {
            abort(403);
        }

        $events = Event::with('updater', 'creator')->orderBy('id', 'desc')->get();
        $vkApiService = new VkApiService();
        $conversations = $vkApiService->getConversations();

        return view('service.admin.events.index', compact('events', 'conversations'));
    }

    public function create(Request $request)
    {
        if (!$request->user()->can('create events')) {
            abort(403);
        }

        $vkApiService = new VkApiService();
        $conversations = $vkApiService->getConversations();

        return view('service.admin.events.create', compact('conversations'));
    }

    public function save(Request $request)
    {
        if (!$request->user()->can('create events')) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|unique:events|max:255',
            'conversation_id' => 'nullable|valid_conversation_id',
            'register_until' => 'required|date',
        ]);

        $event = Event::create($validated);
        request()->session()->flash('status', 'Мероприятие успешно создано');

        /** Отключаем потому что нет возможности выдать админку пользователю через VKApi = неудобно управлять */
//        $vkApiService = new VkApiService();
//        $chat_id = $vkApiService->createChat($event->name);
//
//        if (!empty($validated['conversation_id'])) {
//            $chat_link = $vkApiService->getInviteLink($validated['conversation_id']);
//            $event->update(['conversation_id' => $validated['conversation_id']]);
//            if (!empty($chat_link)) {
//                request()->session()->flash('modal', ['title' => 'Уведомление', 'links' => ['Беседа ВК создана' => $chat_link['link']]]);
//            }
//            else request()->session()->flash('error', 'Возникла проблема при получении ссылки на беседу ВК');
//        }
//        else request()->session()->flash('error', 'Возникла проблема при создании беседы ВК');

        return redirect()->route('admin.events');
    }

    public function edit(Request $request, $id)
    {
        if (!$request->user()->can('edit event')) {
            abort(403);
        }
        $event = Event::findOrFail($id);
        $vkApiService = new VkApiService();
        $conversations = $vkApiService->getConversations();

        return view('service.admin.events.edit', compact('event', 'conversations'));
    }

    public function update(Request $request, $id)
    {
        if (!$request->user()->can('edit events')) {
            abort(403);
        }

        $event = Event::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|max:255|unique:events,name,'.$event->id,
            'register_until' => 'required|date',
            'conversation_id' => 'nullable|valid_conversation_id',
        ]);
        $event->update($validated);
        request()->session()->flash('status', 'Мероприятие обновлено');

        return redirect()->route('admin.events');
    }

    public function delete(Request $request, $id) {
        if (!$request->user()->can('delete events')) {
            abort(403);
        }

        Event::findOrFail($id)->delete();
        $request->session()->flash('status', 'Успешно удалено');

        return redirect()->route('admin.events');
    }

    public function view(Request $request, $id)
    {
        if (!$request->user()->can('view events')) {
            abort(403);
        }

        $event = Event::with('updater', 'creator', 'activities.user.vk')->orderBy('id', 'desc')->findOrFail($id);
        $vkApiService = new VkApiService();
        $response = $vkApiService->getConversationById($event->conversation_id);
        if ($response == null) $event->conversation = null;
        else $event->conversation = [
            'id' => $response['items'][0]['peer']['local_id'],
            'name' => $response['items'][0]['chat_settings']['title'],
            'photo' => $response['items'][0]['chat_settings']['photo']['photo_50'],
            'members_count' => $response['items'][0]['chat_settings']['members_count'],
        ];

        return view('service.admin.events.view', compact('event'));
    }
}
