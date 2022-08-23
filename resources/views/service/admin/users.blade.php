@extends('layouts.service.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md">
                <div class="card">
                    <div class="card-header">{{ __('Пользователи ') }}<span
                                class="badge bg-primary rounded-pill">{{{$users->count()}}}</span></div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success m-2" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
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
                                @foreach($users as $row)
                                    <tr>
                                        @foreach(get_object_vars($row) as $item)
                                            <td>{{{$item}}}</td>
                                        @endforeach
                                        <td>
                                            <a class="btn btn-primary" href="{{route('admin.view', ['id' => $row->id])}}"
                                               role="button">Подробнее</a>
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
