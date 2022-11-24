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
                        @if (session('error'))
                            <div class="alert alert-warning m-2" role="alert">
                                {{ session('error') }}
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
                                    <th scope="col">Название</th>
                                    <th scope="col">Участников</th>
                                    <th scope="col">Описание</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($projects as $project)
                                <tr>
                                    <td>{{{$project->name}}}</td>
                                    <td>{{{$project->project_users_count}}}</td>
                                    <td>{{{$project->description}}}</td>
                                    <td align="right"><a class="btn btn-primary p-1" href="{{route('service.projects.join', ['id' => $project->id])}}" role="button" onclick='return confirm("Вы уверены, что хотите присоединиться к проекту {{{$project->name}}}?");'>Присоединиться</a></td>
                                </tr>
                            @empty
                                <tr class="text-muted">
                                    <td colspan="3">Пусто</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
