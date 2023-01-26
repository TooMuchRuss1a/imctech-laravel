@extends('layouts.landing.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Исключить пользователя из чата "') . $event->name . '"' }}</div>
                    <div class="card-body">
                        <form method="POST"
                              action="{{ route('admin.removeChatUser', ['chat_id' => $event->conversation_id]) }}">
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

                            @error('recaptcha')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                            <div class="row mb-3">
                                <label for="text"
                                       class="col-md-4 col-form-label text-md-end">{{ __('Выберите пользователя') }}</label>

                                <div class="col-md-6">
                                    <select id="user_id" type="text"
                                            class="form-select @error('user_id') is-invalid @enderror" name="user_id"
                                            required>
                                        @foreach ($users as $user)
                                            <option value="{{ $user['id'] }}">
                                                {{ $user['first_name'] }} {{ $user['last_name'] }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('user_id')
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
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" name="Submit" class="btn btn-primary">
                                        {{ __('Исключить') }}
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
