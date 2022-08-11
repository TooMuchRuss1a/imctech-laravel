@extends('layouts.admin.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card">
                <div class="card-header">
                    {{ __('Мероприятия ') }}<span class="badge bg-primary rounded-pill">{{{$events->count()}}}</span>
                    <a class="btn btn-primary p-1 position-absolute" style="top: 2px; right: 10px" href="{{route('admin.events.create')}}" role="button">Создать</a>
                </div>

                @if (session('status'))
                    <div class="alert alert-success m-2" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                @if($keys)
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            @foreach($keys as $key)
                                <th scope="col">{{{$key}}}</th>
                            @endforeach
{{--                                <th>--}}
{{--                                </th>--}}
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($events as $row)
                            <tr>
                                @foreach(get_object_vars($row) as $item)
                                    <td>{{{$item}}}</td>
                                @endforeach
{{--                                    <td>--}}
{{--                                        <a class="btn btn-primary" href="{{route('admin.view', ['id' => $row->id])}}" role="button">Подробнее</a>--}}
{{--                                    </td>--}}
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
@endsection
