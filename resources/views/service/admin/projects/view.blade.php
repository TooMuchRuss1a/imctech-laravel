@extends('layouts.service.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="card">
                    <div class="card-header">Проект
                        <a class="btn btn-primary p-1 position-absolute" style="top: 3px; right: 10px" href="{{route('projects.publish', ['id' => $project->id])}}" role="button">Подготовить к публикации</a>
                    </div>
                    @if (session('status'))
                        <div class="alert alert-success m-2" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-warning m-2" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger m-2" role="alert">
                                {{ $error }}
                            </div>
                        @endforeach
                    @endif
                    <div class="container m-2">
                        <div>Название: {{$project->name}}</div>
                        <div>Описание: {{$project->description}}</div>
                        @if($project->leader_id)
                            <div>Лидер: <a class="link-primary" href="{{route('admin.users.view', ['id' => $project->leader->id])}}">{{$project->leader->name}}</a></div>
                        @else
                            <div>Лидер: —</div>
                        @endif
                        <div>Одобрен к публикации:
                            @if($project->approved)
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16" color="green">
                                    <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/>
                                </svg>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16" color="red">
                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                                </svg>
                            @endif
                        </div>
                        <div><a class="link-primary" href="{{route('admin.projects.testView', ['id' => $project->id])}}">Как выглядит</a></div>
                        <div>Создан: <a class="link-primary" href="{{route('admin.users.view', ['id' => $project->creator->id])}}">{{$project->creator->login}}</a> в {{$project->created_at}}</div>
                        <div>Изменен: <a class="link-primary" href="{{route('admin.users.view', ['id' => $project->updater->id])}}">{{$project->updater->login}}</a> в {{$project->updated_at}}</div>
                    </div>
                </div>
                <div class="card mt-3">
                    <div class="card-header">Команда
                        <span class="badge bg-primary rounded-pill">{{{$project->projectUsers->count()}}}</span>
                    </div>
                    <div class="container m-2">
                        @forelse($project->projectUsers as $projectUser)
                            <div>
                                @if($projectUser->agreement)
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16" color="green">
                                        <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/>
                                    </svg>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16" color="red">
                                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                                    </svg>
                                @endif
                                <a class="link-primary" href="{{route('admin.users.view', ['id' => $projectUser->user->id])}}">{{$projectUser->user->name}}</a>
                                <a class="link-danger" href="{{route('projects.removeUser', ['id' => $project->id, 'user_id' => $projectUser->user_id])}}" onclick='return confirm("Вы уверены, что хотите выгнать участника {{{$projectUser->user->name}}}?");' role="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" color="red" class="bi bi-trash" viewBox="0 0 16 16">
                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                        <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                    </svg>
                                </a>
                            </div>
                        @empty
                            <div>Пусто</div>
                        @endforelse
                    </div>
                </div>
                <div class="card mt-3">
                    <div class="card-header">Лайки
                        <span class="badge bg-primary rounded-pill">{{{$project->projectLikes->count()}}}</span>
                    </div>
                    <div class="container m-2">
                        @forelse($project->projectLikes as $projectLike)
                            <div>
                                <a class="link-primary" href="{{route('admin.users.view', ['id' => $projectLike->user->id])}}">{{$projectLike->user->name}}</a>
                            </div>
                        @empty
                            <div>Пусто</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
