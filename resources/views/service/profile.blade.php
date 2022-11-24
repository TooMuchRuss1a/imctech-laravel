@extends('layouts.service.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="card">
                    <div class="card-header">Информация</div>
                    <div class="container m-2">
                        <div>Логин: {{$user->login}}</div>
                        <div>Почта: {{$user->email}}</div>
                        <div>ФИО: {{$user->name}}</div>
                        <div>Группа: {{$user->agroup}}</div>
                        <div>Создан {{$user->created_at}}</div>
                    </div>
                </div>
                @if(!empty($user->socialData['vk']))
                    <div class="card mt-3">
                        <div class="card-header"><a class="link-primary" href="https://vk.com/id{{$user->socialData['vk']['id']}}">ВКонтакте</a></div>
                        <div class="container m-2" style="display: flex;flex-direction: row;justify-content: flex-start;">
                            <div>
                                <img src="{{$user->socialData['vk']['photo_50']}}" class="rounded-5 p-1 d-inline" style="width: 50px">
                            </div>
                            <div style="padding-left: 5px">
                                <div>{{$user->socialData['vk']['first_name'] . ' ' . $user->socialData['vk']['last_name']}}</div>
                                <div>{{$user->socialData['vk']['status']}}</div>
                            </div>
                        </div>
                    </div>
                @elseif(!empty($user->vk))
                    <div class="card mt-3">
                        <div class="card-header">ВКонтакте</div>
                        <div class="container m-2" style="display: flex;flex-direction: row;justify-content: flex-start;">
                            <div>
                                <img src="https://vk.com/images/deactivated_100.png" class="rounded-5 p-1 d-inline" style="width: 50px">
                            </div>
                            <div style="padding-left: 5px">
                                <div>invalid</div>
                                <div>{{$user->vk->link}}</div>
                            </div>
                        </div>
                    </div>
                @endif
                @if(!empty($user->activities->first()))
                    <div class="card mt-3">
                        <div class="card-header">Активность</div>
                        <div class="container m-2">
                            @foreach($user->activities as $activity)
                                <div>{{$activity->event->name}}</div>
                            @endforeach
                        </div>
                    </div>
                @endif
                @if(!empty($user->userProjects->first()))
                    <div class="card mt-3">
                        <div class="card-header">Проекты</div>
                        <div class="container m-2">
                            @foreach($user->userProjects as $userProjects)
                                <div><a class="link-primary" href="{{route('service.projects.view', ['id' => $userProjects->project->id])}}">{{$userProjects->project->name}}</a></div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
