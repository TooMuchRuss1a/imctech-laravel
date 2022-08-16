@extends('layouts.service.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="card">
                    <div class="card-header">{{ __('Аудит') }}</div>

                    <div class="card-body">
                        @if(!empty($keys))
                            <table class="table table-hover m-2">
                                <thead>
                                <tr>
                                    @foreach($keys as $key)
                                        <th scope="col">{{{$key}}}</th>
                                    @endforeach
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($audits as $row)
                                    <tr>
                                        @foreach(get_object_vars($row) as $item)
                                            @if(in_array($loop->index, [5, 6]) && !empty($item))
                                                <td>
                                                    <div class="nav-item dropdown">
                                                        <a class="nav-link dropdown-toggle text-primary"
                                                           id="navbarDropdownMenuLink" role="button"
                                                           data-bs-toggle="dropdown" aria-expanded="false">
                                                            Показать
                                                        </a>
                                                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                                            <a class="dropdown-item" title="Скопировать"
                                                               id="{{$keys[$loop->index].$row->id }}"
                                                               onclick="copyToClipboard('#{{$keys[$loop->index].$row->id }}')">
                                                                <pre>{{{print_r($item)}}}</pre>
                                                            </a>
                                                        </ul>
                                                    </div>
                                                </td>
                                            @elseif(!empty($item))
                                                <td>{{{$item}}}</td>
                                            @else
                                                <td></td>
                                            @endif
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