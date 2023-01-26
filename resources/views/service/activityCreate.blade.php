@extends('layouts.service.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Запись на мероприятие') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('service.activity') }}">
                        @csrf
                        <div class="row mb-3">
                            <label for="text" class="col-md-4 col-form-label text-md-end">{{ __('Выберите мероприятие') }}</label>

                            <div class="col-md-6">
                                <select class="form-select" name="event_id">
                                    @foreach ($events as $event)
                                        <option @if(request()->id == $event->id) selected @endif value="{{ $event->id }}">
                                            {{ $event->name }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('event_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" name="Submit" class="btn btn-primary">
                                    {{ __('Записаться') }}
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
