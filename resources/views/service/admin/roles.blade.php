@extends('layouts.service.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="card">
                    <div class="card-header">{{ __('Роли ') }}<span
                                class="badge bg-primary rounded-pill">{{{$roles->count()}}}</span>
                        <a class="btn btn-primary p-1 position-absolute" style="top: 2px; right: 10px"
                           href="{{route('admin.roles.create')}}" role="button">Выдать</a>
                    </div>

                    @if (session('status'))
                        <div class="alert alert-success m-2" role="alert">
                            {{ session('status') }}
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
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($roles as $row)
                                    <tr>
                                        @foreach(get_object_vars($row) as $item)
                                            <td>{{{$item}}}</td>
                                        @endforeach
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
