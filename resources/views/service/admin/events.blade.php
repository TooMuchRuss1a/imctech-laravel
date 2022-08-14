@extends('layouts.service.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="card">
                    <div class="card-header">
                        {{ __('Мероприятия ') }}<span
                                class="badge bg-primary rounded-pill">{{{$events->count()}}}</span>
                        <a class="btn btn-primary p-1 position-absolute" style="top: 2px; right: 10px"
                           href="{{route('admin.events.create')}}" role="button">Создать</a>
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
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    @foreach($keys as $key)
                                        <th scope="col">{{{$key}}}</th>
                                    @endforeach
                                                                    <th>
                                                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($events as $event)
                                    <tr @if($event->register_until > now()) style="background-color: palegreen;"@endif>
                                        @foreach(get_object_vars($event) as $item)
                                            @if(!empty($item) && $loop->index == 2)
                                                <td><a href="{{route('admin.removeChatUser', ['chat_id' => $item])}}" class="link-primary">{{$item}}</a></td>
                                            @else
                                                <td>{{{$item}}}</td>
                                            @endif
                                        @endforeach
                                        <td>
                                            <a href="{{route('admin.edit', ['table' => 'events', 'id' => $event->id])}}" type="button" class="btn btn-outline-secondary">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pen" viewBox="0 0 16 16">
                                                    <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001zm-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708l-1.585-1.585z"></path>
                                                </svg>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="p-2">Пусто</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
