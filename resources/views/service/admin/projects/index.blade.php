@extends('layouts.service.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md">
                <div class="card">
                    <div class="card-header">Проекты
                        <span class="badge bg-primary rounded-pill">{{{$projects->count()}}}</span>
                    </div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success m-2" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger" role="alert">
                                    {{ $error }}
                                </div>
                            @endforeach
                        @endif
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">id</th>
                                    <th scope="col">name</th>
                                    <th scope="col">leader</th>
                                    <th scope="col">approved</th>
                                    <th scope="col">updated_at</th>
                                    <th scope="col">updated_by</th>
                                    <th scope="col">created_at</th>
                                    <th scope="col">created_by</th>
                                    <th scope="col">likes</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($projects as $project)
                                <tr>
                                    <td>
                                        <a class="link-primary" href="{{route('admin.projects.view', ['id' => $project->id])}}">{{{$project->id}}}</a>
                                    </td>
                                    <td>{{{$project->name}}}</td>
                                    <td>
                                        @if($project->leader)
                                            <a class="link-primary" href="{{route('admin.users.view', ['id' => $project->leader->id])}}">{{$project->leader->login}}</a>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16" color="red">
                                                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                                            </svg>
                                        @endif
                                    </td>
                                    <td>
                                        @if($project->approved)
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check" viewBox="0 0 16 16" color="green">
                                                <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/>
                                            </svg>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16" color="red">
                                                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                                            </svg>
                                        @endif
                                    </td>
                                    <td>{{{$project->updated_at}}}</td>
                                    <td><a class="link-primary" href="{{route('admin.users.view', ['id' => $project->updater->id])}}">{{$project->updater->login}}</a></td>
                                    <td>{{{$project->created_at}}}</td>
                                    <td><a class="link-primary" href="{{route('admin.users.view', ['id' => $project->creator->id])}}">{{$project->creator->login}}</a></td>
                                    <td>{{{$project->project_likes_count}}}</td>
                                    <td>
                                        <a class="btn btn-outline-secondary" href="{{route('admin.projects.edit', ['id' => $project->id])}}" role="button">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pen" viewBox="0 0 16 16">
                                                <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001zm-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708l-1.585-1.585z"></path>
                                            </svg>
                                        </a>
                                        <a class="btn btn-outline-danger" href="{{route('admin.projects.delete', ['id' => $project->id])}}" onclick='return confirm("Вы уверены, что хотите удалить проект?");' role="button">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr class="text-muted">
                                    <td colspan="9">Пусто</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        <a href="{{{route('admin.projects.create')}}}" role="button" class="btn btn-primary p-1">Создать</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
