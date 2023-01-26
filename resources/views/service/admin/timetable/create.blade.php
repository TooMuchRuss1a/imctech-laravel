@extends('layouts.service.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Создание дня') }}</div>

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
                        <form method="POST" action="{{ route('admin.timetable.create') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="data" class="col-md-4 col-form-label text-md-end">{{ __('День') }}</label>
                                <div class="col-md-6">
                                    <input id="date" type="text" class="form-control datepicker @error('date') is-invalid @enderror" name="date" value="{{ old('date') }}" required autofocus autocomplete="off" placeholder="2022-01-01">
                                    @error('date')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Название') }}</label>
                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="off" placeholder="Презентация проектов">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="place" class="col-md-4 col-form-label text-md-end">{{ __('Аудитория') }}</label>
                                <div class="col-md-6">
                                    <input id="place" type="text" class="form-control @error('place') is-invalid @enderror" name="place" value="{{ old('place') }}" required autocomplete="off" placeholder="G464">
                                    @error('place')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="rows">
                                <div class="row-0">
                                    <div class="text-center">Событие 1</div>
                                    <div class="row mb-3">
                                        <label for="data" class="col-md-4 col-form-label text-md-end">{{ __('С') }}</label>
                                        <div class="col-md-6">
                                            <input id="from-0" type="text" class="form-control @error('from-0') is-invalid @enderror" name="from-0" value="{{ old('from-0') }}" required autocomplete="off" placeholder="12:00">
                                            @error('from-0')
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="data" class="col-md-4 col-form-label text-md-end">{{ __('До') }}</label>
                                        <div class="col-md-6">
                                            <input id="to-0" type="text" class="form-control @error('to-0') is-invalid @enderror" name="to-0" value="{{ old('to-0') }}" required autocomplete="off" placeholder="13:00">
                                            @error('to-0')
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="data" class="col-md-4 col-form-label text-md-end">{{ __('Описание') }}</label>
                                        <div class="col-md-6">
                                            <textarea id="description-0" type="text" class="form-control @error('description-0') is-invalid @enderror" name="description-0" required autocomplete="off" placeholder="Что будет, спикеры и тд">{{ old('description-0') }}</textarea>
                                            @error('description-0')
                                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
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
                                    let newRow = $('<div class="row-'+ counter +'">Событие '+ counter);
                                    newRow.append($('<div class="text-center">Событие '+ ++counter +'</div>'));
                                    counter--;
                                    newRow.append($('<div class="row mb-3"> <label for="data" class="col-md-4 col-form-label text-md-end">{{ __('С') }}</label> <div class="col-md-6"> <input id="from-'+ counter +'" type="text" class="form-control" name="from-'+ counter +'" required autocomplete="off" placeholder="12:00"></div> </div>'));
                                    newRow.append($('<div class="row mb-3"> <label for="data" class="col-md-4 col-form-label text-md-end">{{ __('До') }}</label> <div class="col-md-6"> <input id="to-'+ counter +'" type="text" class="form-control" name="to-'+ counter +'" required autocomplete="off" placeholder="13:00"></div> </div>'));
                                    newRow.append($('<div class="row mb-3"> <label for="data" class="col-md-4 col-form-label text-md-end">{{ __('Описание') }}</label> <div class="col-md-6"> <textarea id="description-'+ counter +'" type="text" class="form-control" name="description-'+ counter +'" required autocomplete="off" placeholder="Что будет, спикеры и тд"></textarea></div> </div>'));
                                    newRow.append($('</div>'));
                                    $('.rows').append(newRow);
                                }
                                function  removeRow()
                                {
                                    if (counter >= 0) $('.row-'+ counter--).remove();
                                }
                            </script>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
