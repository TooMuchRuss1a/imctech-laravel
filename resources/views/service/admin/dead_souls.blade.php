@extends('layouts.service.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md">
                <div class="card">
                    <div class="card-header">{{ __('Мертвые души ') }}<span class="badge bg-primary rounded-pill">{{{$users->count()}}}</span></div>
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th scope="col">id</th>
                                <th scope="col">name</th>
                                <th scope="col">email</th>
                                <th scope="col">email_verified_at</th>
                                <th scope="col">agroup</th>
                                <th scope="col">vk</th>
                                <th scope="col">created_at</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($users as $user)
                                <tr>
                                    <td><a class="link-primary" href="{{{route('admin.users.view', ['id' => $user->id])}}}">{{$user->id}}</a></td>
                                    <td>{{{$user->name}}}</td>
                                    <td>{{{$user->email}}}</td>
                                    <td>{{{$user->email_verified_at}}}</td>
                                    <td>{{{$user->agroup}}}</td>
                                    <td><a class="link-primary" href="{{{$user->vk->link}}}">{{$user->vk->link}}</a></td>
                                    <td>{{{$user->created_at}}}</td>
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
