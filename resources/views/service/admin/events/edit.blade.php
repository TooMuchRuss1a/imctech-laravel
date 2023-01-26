@extends('layouts.service.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Редактирование мероприятия') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.events.edit', ['id' => $event->id]) }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Название') }}</label>
                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') ? old('name') : $event->name }}" required autocomplete="name" autofocus>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="data" class="col-md-4 col-form-label text-md-end">{{ __('Регистрация до') }}</label>
                                <div class="col-md-6">
                                    <input id="register_until" type="text" class="form-control datepicker @error('register_until') is-invalid @enderror" name="register_until" value="{{ old('register_until') ? old('register_until') : $event->register_until }}" required autocomplete="register_until">
                                    @error('register_until')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="text" class="col-md-4 col-form-label text-md-end">{{ __('Выберите беседу') }}</label>
                                <div class="col-md-6">
                                    <select id="conversation_id" type="text" class="form-select @error('conversation_id') is-invalid @enderror" name="conversation_id">
                                        <option value="">Нет</option>
                                        @foreach ($conversations as $conversation)
                                            <option @if($conversation['id'] == $event->conversation_id) selected @endif value="{{ $conversation['id'] }}">
                                                {{ $conversation['name'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('conversation_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-0 mt-4">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" name="Submit" class="btn btn-primary">
                                        {{ __('Обновить') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
