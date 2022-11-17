@extends('layouts.service.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md">
                <div class="card">
                    <div class="card-header">{{ __('Роли ') }}<span
                                class="badge bg-primary rounded-pill">{{{$roles->count()}}}</span>
                        <a class="btn btn-primary p-1 position-absolute" style="top: 2px; right: 10px"
                           href="{{route('admin.roles.create')}}" role="button">Создать</a>
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
                        @if(!empty($keys))
                            @foreach($roles as $role)
                            <table class="table table-hover" style="margin-bottom: 40px">
                                <thead>
                                    <tr>
                                        <th style="display: flex; justify-content: space-between">
                                            {{{$role->name}}}
                                            <a href="{{route('admin.roleDelete', ['id' => $role->id])}}" type="button" class="btn btn-outline-danger">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                                </svg>
                                            </a>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <th style="display: flex; justify-content: space-between">
                                        Пользователи
                                        <a href="{{route('admin.userAdd', ['id' => $role->id])}}" type="button" class="btn btn-outline-secondary">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                                                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                                            </svg>
                                        </a>
                                    </th>
                                </tr>
                                @forelse($role->users as $user)
                                    <tr >
                                        <td style="display: flex; justify-content: space-between">
                                            <a class="link-primary" href="{{route('admin.users.view', ['id' => $user->id])}}">{{$user->login}}</a>
                                            <a href="{{route('admin.userRemove', ['id' => $role->id, 'user_id' => $user->id])}}" type="button" class="btn btn-outline-danger">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                                </svg>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td>Отсутствуют</td>
                                    </tr>
                                @endforelse
                                    <th style="display: flex; justify-content: space-between">
                                        Права
                                        <a href="{{route('admin.permissionAdd', ['id' => $role->id])}}" type="button" class="btn btn-outline-secondary">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                                                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                                            </svg>
                                        </a>
                                    </th>
                                @forelse($role->permissions as $permission)
                                    <tr>
                                        <td style="display: flex; justify-content: space-between">
                                            {{{$permission->name}}}
                                            <a href="{{route('admin.permissionRemove', ['id' => $role->id, 'permission_id' => $permission->id])}}" type="button" class="btn btn-outline-danger">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                                </svg>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td>@if($role->name == 'root') Неограничено @else Отсутствуют @endif</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                            @endforeach
                        @else
                            <div class="p-2">Пусто</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
