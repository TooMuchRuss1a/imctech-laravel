@extends('layouts.service.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="card">
                    <div class="card-header">{{ __('Информация ') }}</span>  <a class="btn btn-primary p-1 position-absolute" style="top: 3px; right: 10px" href="{{route('admin.edit', ['table' => 'users', 'id' => $user->id])}}" role="button">Редактировать</a></div>
                    <div class="container m-2">
                        <div>Логин: {{$user->login}}</div>
                        <div>Почта: {{$user->email}}</div>
                        <div>ФИО: {{$user->name}}</div>
                        <div>Группа: {{$user->agroup}}</div>
                        <div>Создан: <a class="link-primary" href="{{route('admin.users.view', ['id' => $user->creator->id])}}">{{$user->creator->login}}</a> в {{$user->created_at}}</div>
                        <div>Изменен: <a class="link-primary" href="{{route('admin.users.view', ['id' => $user->updater->id])}}">{{$user->updater->login}}</a> в {{$user->updated_at}}</div>
                    </div>
                </div>
                @if(!empty($user->socialData['vk']))
                    <div class="card mt-3">
                        <div class="card-header"><a class="link-primary" href="https://vk.com/id{{$user->socialData['vk']['id']}}">{{ __('ВКонтакте') }}</a>  <a class="btn btn-primary p-1 position-absolute" style="top: 3px; right: 10px" href="{{route('admin.edit', ['table' => 'socials', 'id' => $user->socials()->where('type', 'vk')->first()->id])}}" role="button">Редактировать</a> </div>
                        <div class="container p-2">
                            <div class="container" style="display: flex;flex-direction: row;justify-content: flex-start;">
                                <div><img src="{{$user->socialData['vk']['photo_50']}}" class="rounded-5 p-1 d-inline"
                                          style="width: 50px"></div>
                                <div style="padding-left: 5px">
                                    <div>{{$user->socialData['vk']['first_name'] . ' ' . $user->socialData['vk']['last_name']}}</div>
                                    <div>{{$user->socialData['vk']['status']}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif(!empty($user->socials()->where('type', 'vk')->first()))
                    <div class="card mt-3">
                        <div class="card-header">{{ __('ВКонтакте') }}</span>  <a class="btn btn-primary p-1 position-absolute" style="top: 3px; right: 10px" href="{{route('admin.edit', ['table' => 'socials', 'id' => $user->socials()->where('type', 'vk')->first()->id])}}" role="button">Редактировать</a> </div>
                        <div class="container p-2">
                            <div class="container"
                                 style="display: flex;flex-direction: row;justify-content: flex-start;">
                                <div><img src="https://vk.com/images/deactivated_100.png" class="rounded-5 p-1 d-inline" style="width: 50px"></div>
                                <div style="padding-left: 5px">
                                    <div>invalid</div>
                                    <div>{{$user->socials()->where('type', 'vk')->first()->link}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if(!empty($user->activities->first()))
                    <div class="card mt-3">
                        <div class="card-header">{{ __('Активность') }}</span></div>
                        <div class="container p-2">
                            <div class="container">
                                @foreach($user->activities as $activity)
                                    <div style="padding-left: 5px">
                                        <div>{{$activity->event->name}}</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
