@extends('layouts.service.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md">
                <div class="card">
                    <div class="card-header">
                        {{ __('Мероприятия ') }}
                        <span class="badge bg-primary rounded-pill">{{{$events->count()}}}</span>
                        <a class="btn btn-primary p-1 position-absolute" style="top: 2px; right: 10px" href="{{route('admin.events.create')}}" role="button">Создать</a>
                    </div>

                    @if (session('status'))
                        <div class="alert alert-success m-2" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger m-2" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="card-body">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">id</th>
                                        <th scope="col">name</th>
                                        <th scope="col">conversation</th>
                                        <th scope="col">register_until</th>
                                        <th scope="col">updated_at</th>
                                        <th scope="col">updated_by</th>
                                        <th scope="col">created_at</th>
                                        <th scope="col">created_by</th>
                                        <th>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($events as $event)
                                        <tr @if($event->register_until > now()) style="background-color: palegreen;"@endif>
                                            <td>{{{$event->id}}}</td>
                                            <td>
                                                {{{$event->name}}}
                                                <br>
                                                <a class="link-primary" href="{{route('admin.events.view', ['id' => $event->id])}}">Подробнее</a>
                                            </td>
                                            <td>
                                                @if(empty($event->conversation_id))
                                                    <a class="link-danger text-decoration-none" href="{{route('admin.events.edit', ['id' => $event->id])}}">Пусто</a>
                                                @else
                                                    <a href="{{route('admin.removeChatUser', ['chat_id' => $event->conversation_id])}}" class="link-primary">{{$conversations[array_search($event->conversation_id, array_column($conversations, 'id'))]['name']}}</a>
                                                @endif
                                            </td>
                                            <td>{{{$event->register_until}}}</td>
                                            <td>{{{$event->updated_at}}}</td>
                                            <td><a class="link-primary" href="{{route('admin.view', ['id' => $event->updater->id])}}">{{$event->updater->login}}</a></td>
                                            <td>{{{$event->created_at}}}</td>
                                            <td><a class="link-primary" href="{{route('admin.view', ['id' => $event->creator->id])}}">{{$event->creator->login}}</a></td>
                                            <td>
                                                <a class="btn btn-outline-secondary" href="{{route('admin.events.edit', ['id' => $event->id])}}" role="button">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pen" viewBox="0 0 16 16">
                                                        <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001zm-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708l-1.585-1.585z"></path>
                                                    </svg>
                                                </a>
                                                <a class="btn btn-outline-danger" href="{{route('admin.events.delete', ['id' => $event->id])}}" onclick='return confirm("Вы уверены, что хотите удалить мероприятие?");' role="button">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                                        <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                                    </svg>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <div class="p-2">Пусто</div>
                                    @endforelse
                                </tbody>
                            </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
