@extends('layouts.service.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="card">
                    <div class="card-header">{{ __('Мероприятие') }}<a class="btn btn-primary p-1 position-absolute" style="top: 3px; right: 10px" href="{{route('admin.events.edit', ['id' => $event->id])}}" role="button">Редактировать</a></div>
                    <div class="container m-2">
                        <div>Название: {{$event->name}}</div>
                        <div>Регистрация до: {{$event->register_until}}</div>
                        <div>Создан: <a class="link-primary" href="{{route('admin.users.view', ['id' => $event->creator->id])}}">{{$event->creator->login}}</a> в {{$event->created_at}}</div>
                        <div>Изменен: <a class="link-primary" href="{{route('admin.users.view', ['id' => $event->updater->id])}}">{{$event->updater->login}}</a> в {{$event->updated_at}}</div>
                    </div>
                </div>
                @if(!empty($event->conversation))
                    <div class="card mt-3">
                        <div class="card-header">{{ __('Беседа ВК') }}</div>
                        <div class="container p-2">
                            <div class="container" style="display: flex;flex-direction: row;justify-content: flex-start;">
                                <div><img src="{{$event->conversation['photo']}}" class="rounded-5 p-1 d-inline" style="width: 50px"></div>
                                <div style="padding-left: 5px">
                                    <div>{{$event->conversation['name']}}</div>
                                    <div>{{{$event->conversation['members_count']}}} участников</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="card mt-3">
                    <div class="card-header">
                        {{ __('Участники') }}
                        <span class="badge bg-primary rounded-pill">{{{$event->activities->count()}}}</span>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th scope="col">№</th>
                                <th scope="col">name</th>
                                <th scope="col">email</th>
                                <th scope="col">agroup</th>
                                <th scope="col">vk</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($event->activities as $activity)
                                <tr>
                                    <td>{{{$loop->iteration}}}</td>
                                    <td>{{{$activity->user->name}}}</td>
                                    <td>{{{$activity->user->email}}}</td>
                                    <td>{{{$activity->user->agroup}}}</td>
                                    <td><a class="link-primary" href="{{{$activity->user->vk->link}}}">{{$activity->user->vk->link}}</a></td>
                                    <td>
                                        <a class="btn btn-primary" href="{{route('admin.users.view', ['id' => $activity->user->id])}}" role="button">Подробнее</a>
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
