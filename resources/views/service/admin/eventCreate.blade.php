@extends('layouts.service.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Создание мероприятия') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.events.create') }}">
                            @csrf
                            <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.sitekey') }}"></script>
                            <script>
                                grecaptcha.ready(function () {
                                    grecaptcha.execute('{{ config('services.recaptcha.sitekey') }}', {action: 'contact'}).then(function (token) {
                                        if (token) {
                                            document.getElementById('recaptcha').value = token;
                                        }
                                    });
                                });
                            </script>

                            <div class="row mb-3">
                                <label for="name"
                                       class="col-md-4 col-form-label text-md-end">{{ __('Название') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text"
                                           class="form-control @error('name') is-invalid @enderror" name="name"
                                           value="{{ old('name') }}" required autocomplete="name" autofocus>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="data"
                                       class="col-md-4 col-form-label text-md-end">{{ __('Регистрация до') }}</label>

                                <div class="col-md-6">
                                    <input id="register_until" type="text"
                                           class="form-control datepicker @error('register_until') is-invalid @enderror"
                                           name="register_until" value="{{ old('register_until') }}" required
                                           autocomplete="register_until">

                                    @error('register_until')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="text" class="col-md-4 col-form-label text-md-end">{{ __('') }}</label>

                                <div class="col-md-6">
                                    <input id="recaptcha" type="hidden"
                                           class="form-control @error('recaptcha') is-invalid @enderror"
                                           name="recaptcha" value="" required>

                                    @error('recaptcha')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" name="Submit" class="btn btn-primary">
                                        {{ __('Создать') }}
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
