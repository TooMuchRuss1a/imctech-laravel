@extends('layouts.service.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Создание проекта') }}</div>

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
                        <form method="POST" action="{{ route('admin.projects.create') }}">
                            @csrf

                            <div class="rows">
                                <div class="row-0">
                                    <div class="text-center">Проект 1</div>
                                    <div class="row mb-3">
                                        <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Название') }}</label>
                                        <div class="col-md-6">
                                            <input id="name-0" type="text" class="form-control" name="name-0" value="{{ old('name-0') }}" required autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="data" class="col-md-4 col-form-label text-md-end">{{ __('Описание') }}</label>
                                        <div class="col-md-6">
                                            <textarea id="description-0" type="text" class="form-control" name="description-0" autocomplete="off" placeholder="Краткое описание">{{ old('description-0') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <a onclick="addRow()" class="btn btn-secondary" style="margin-bottom: 2px">
                                        {{ __('Добавить еще') }}
                                    </a>
                                </div>
                            </div>
                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <a onclick="removeRow()" class="btn btn-danger">
                                        {{ __('Удалить последнее') }}
                                    </a>
                                </div>
                            </div>

                            <div class="row mb-0 mt-4">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" name="Submit" class="btn btn-primary">
                                        {{ __('Создать') }}
                                    </button>
                                </div>
                            </div>

                            <script>
                                var counter = 0;
                                function  addRow()
                                {
                                    counter++;
                                    let newRow = $('<div class="row-'+ counter +'">');
                                    newRow.append($('<div class="text-center">Проект '+ ++counter +'</div>'));
                                    counter--;
                                    newRow.append($('<div class="row mb-3"><label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Название') }}</label><div class="col-md-6"><input id="name-'+ counter +'" type="text" class="form-control" name="name-'+ counter +'" required autocomplete="off"></div></div>'));
                                    newRow.append($('<div class="row mb-3"><label for="data" class="col-md-4 col-form-label text-md-end">{{ __('Описание') }}</label><div class="col-md-6"><textarea id="description-'+ counter +'" type="text" class="form-control" name="description-'+ counter +'" autocomplete="off" placeholder="Краткое описание">{{ old('description-0') }}</textarea></div></div>'));
                                    newRow.append($('</div>'));
                                    $('.rows').append(newRow);
                                }
                                function  removeRow()
                                {
                                    if (counter >= 1) $('.row-'+ counter--).remove();
                                }
                            </script>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
