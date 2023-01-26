@extends('layouts.landing.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="card">
                    <div class="card-header">{{ __('Информация') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success m-2" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-warning m-2" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif

                        <div class="p-1">IMCTechService - сервис, позволяющий пользователям взаимодействовать внутри
                            экосистемы IMCTech
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
