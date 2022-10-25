@extends('layouts.service.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Редактирование дня') }}</div>

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
                        <form method="POST" action="{{ route('admin.timetable.edit', ['id' => $day->id]) }}">
                            @csrf
                            <div class="row mb-3">
                                <label for="data" class="col-md-4 col-form-label text-md-end">{{ __('День') }}</label>
                                <div class="col-md-6">
                                    <input id="date" type="text" class="form-control datepicker @error('date') is-invalid @enderror" name="date" value="{{ old('date') ? old('date') : $day->date->format('Y-m-d') }}" required autofocus autocomplete="off" placeholder="2022-01-01">
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
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') ? old('name') : $day->name }}" required autocomplete="off" placeholder="Презентация проектов">
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
                                    <input id="place" type="text" class="form-control @error('place') is-invalid @enderror" name="place" value="{{ old('place') ? old('place') : $day->place }}" required autocomplete="off" placeholder="G464">
                                    @error('place')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="rows">
                                @forelse($day->timelines as $timeline)
                                    <div class="row-{{{$loop->index}}}">
                                        <div class="text-center">Событие {{{$loop->iteration}}}</div>
                                        <div class="row mb-3">
                                            <label for="data" class="col-md-4 col-form-label text-md-end">{{ __('С') }}</label>
                                            <div class="col-md-6">
                                                <input id="from-{{{$loop->index}}}" type="text" class="form-control @error('from-'.$loop->index) is-invalid @enderror" name="from-{{{$loop->index}}}" value="{{ old('from-'.$loop->index) ? old('from-'.$loop->index) : $timeline->from->format('H:i') }}" required autocomplete="off" placeholder="12:00">
                                                @error('from-'.$loop->index)
                                                <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="data" class="col-md-4 col-form-label text-md-end">{{ __('До') }}</label>
                                            <div class="col-md-6">
                                                <input id="to-{{{$loop->index}}}" type="text" class="form-control @error('to-'.$loop->index) is-invalid @enderror" name="to-{{{$loop->index}}}" value="{{ old('to-'.$loop->index) ? old('to-'.$loop->index) : $timeline->to->format('H:i') }}" required autocomplete="off" placeholder="13:00">
                                                @error('to-'.$loop->index)
                                                <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label for="data" class="col-md-4 col-form-label text-md-end">{{ __('Описание') }}</label>
                                            <div class="col-md-6">
                                                <textarea id="description-{{{$loop->index}}}" type="text" class="form-control @error('description-'.$loop->index) is-invalid @enderror" name="description-{{{$loop->index}}}" required autocomplete="off" placeholder="Что будет, спикеры и тд">{{ old('description-'.$loop->index) ? old('description-'.$loop->index) : $timeline->description }}</textarea>
                                                @error('description-'.$loop->index)
                                                <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                @endforelse
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
                                        {{ __('Обновить') }}
                                    </button>
                                </div>
                            </div>

                            <script>
                                var counter = {{{$day->timelines->count()-1}}};
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
