@extends('layouts.landing.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md">
                <div class="card">
                    <div class="card-header">{{ __('Расписание ') }}
                        @if(cache('timetable'))
                            <a class="btn btn-danger p-1 position-absolute" style="top: 3px; right: 10px"
                               href="{{route('admin.timetable.toggle')}}" role="button">Выключить отображение</a>
                        @else
                            <a class="btn btn-primary p-1 position-absolute" style="top: 3px; right: 10px"
                               href="{{route('admin.timetable.toggle')}}" role="button">Включить отображение</a>
                        @endif
                        <span class="badge bg-primary rounded-pill">{{{$days->count()}}}</span>
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
                                <th scope="col">day</th>
                                <th scope="col">name</th>
                                <th scope="col">updated_at</th>
                                <th scope="col">updated_by</th>
                                <th scope="col">created_at</th>
                                <th scope="col">created_by</th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($days as $day)
                                <tr>
                                    <td>{{{$day->date->locale('ru')->isoFormat('D MMMM')}}}</td>
                                    <td>{{{$day->name}}}</td>
                                    <td>{{{$day->updated_at}}}</td>
                                    <td><a class="link-primary"
                                           href="{{route('admin.users.view', ['id' => $day->updater->id])}}">{{$day->updater->login}}</a>
                                    </td>
                                    <td>{{{$day->created_at}}}</td>
                                    <td><a class="link-primary"
                                           href="{{route('admin.users.view', ['id' => $day->creator->id])}}">{{$day->creator->login}}</a>
                                    </td>
                                    <td>
                                        <a class="btn btn-outline-secondary"
                                           href="{{route('admin.timetable.edit', ['id' => $day->id])}}" role="button">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                 fill="currentColor" class="bi bi-pen" viewBox="0 0 16 16">
                                                <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001zm-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708l-1.585-1.585z"></path>
                                            </svg>
                                        </a>
                                        <a class="btn btn-outline-danger"
                                           href="{{route('admin.timetable.delete', ['id' => $day->id])}}"
                                           onclick='return confirm("Вы уверены, что хотите удалить день со всеми входящими в него событиями?");'
                                           role="button">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                 fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                                <path fill-rule="evenodd"
                                                      d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                            </svg>
                                        </a>
                                    </td>
                                </tr>

                                @forelse($day->timelines as $timeline)
                                    <tr>
                                        <td class="text-muted">{{{$timeline->from->format('H:i')}}}
                                            - {{{$timeline->to->format('H:i')}}}</td>
                                        <td class="text-muted"
                                            colspan="6">{!!nl2br(htmlspecialchars($timeline->description))!!}</td>
                                    </tr>
                                @empty
                                    <tr class="text-muted">
                                        <td colspan="7">Пусто</td>
                                    </tr>
                                @endforelse
                            @empty
                                <tr class="text-muted">
                                    <td colspan="7">Пусто</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        <a href="{{{route('admin.timetable.create')}}}" role="button" class="btn btn-primary p-1">Создать</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
