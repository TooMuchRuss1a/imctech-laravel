@extends('layouts.service.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Редактирование') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.edit', ['table' => $item->getTable(), 'id' => $item->id]) }}">
                        @csrf
                        <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.sitekey') }}"></script>
                        <script>
                            grecaptcha.ready(function() {
                                grecaptcha.execute('{{ config('services.recaptcha.sitekey') }}', {action: 'contact'}).then(function(token) {
                                    if (token) {
                                        document.getElementById('recaptcha').value = token;
                                    }
                                });
                            });
                        </script>

                        @error('recaptcha')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror

                        @foreach($item->getFillable() as $key)
                            <div class="row mb-3">
                                <label for="text" class="col-md-4 col-form-label text-md-end">{{ $key }}</label>

                                <div class="col-md-6">
                                    <input id="{{ $key }}" type="text" class="form-control @error($key) is-invalid @enderror" name="{{$key}}" value="{{ (!empty(old($key))) ? old($key) : $item->$key }}" autofocus>

                                    @error($key)
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        @endforeach

                        <div class="row mb-3">
                            <label for="text" class="col-md-4 col-form-label text-md-end">{{ __('') }}</label>

                            <div class="col-md-6">
                                <input id="recaptcha" type="hidden" class="form-control @error('recaptcha') is-invalid @enderror" name="recaptcha" value="" required>

                                @error('recaptcha')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" name="Submit" class="btn btn-primary">
                                    {{ __('Отправить') }}
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
