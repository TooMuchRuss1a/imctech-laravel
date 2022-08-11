@extends('layouts.admin.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card">
                <div class="card-header">{{ __('Информация ') }}</span></div>
                <div class="container m-2">
                    <div>Логин: {{$user->login}}</div>
                    <div>Почта: {{$user->email}}</div>
                    <div>ФИО: {{$user->name}}</div>
                    <div>Группа: {{$user->agroup}}</div>
                    <div>Создан: {{$user->created_at}}</div>
                    <div>Изменен: {{$user->updated_at}}</div>
                </div>
            </div>
            @if(!empty($user->socialData['vk']))
                <div class="card mt-3">
                    <div class="card-header">{{ __('ВКонтакте') }}</span></div>
                    <div class="container p-2">
                        <div class="container" style="display: flex;flex-direction: row;justify-content: flex-start;">
                            <div><img src="{{$user->socialData['vk']->photo_50}}" class="rounded-5 p-1 d-inline" style="width: 50px"></div>
                            <div style="padding-left: 5px">
                                <div>{{$user->socialData['vk']->first_name . ' ' . $user->socialData['vk']->last_name}}</div>
                                <div>{{$user->socialData['vk']->status}}</div>
                            </div>
                            <a class="btn btn-primary position-absolute" rel="noopener noreferrer" target="_blank" style="right: 10px; margin-top: 5px" href="https://vk.com/id{{$user->socialData['vk']->id}}" role="button">Открыть</a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
