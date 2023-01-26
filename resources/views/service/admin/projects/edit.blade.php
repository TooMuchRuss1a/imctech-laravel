@extends('layouts.landing.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Редактирование проекта') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.projects.edit', ['id' => $project->id]) }}">
                            @csrf
                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end">Название</label>
                                <div class="col-md-6">
                                    <input id="name" type="text"
                                           class="form-control @error('name') is-invalid @enderror" name="name"
                                           value="{{ old('name') ? old('name') : $project->name }}" required
                                           autocomplete="off">
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="data" class="col-md-4 col-form-label text-md-end">Описание</label>
                                <div class="col-md-6">
                                    <textarea id="description" type="text" class="form-control" name="description"
                                              autocomplete="off"
                                              placeholder="Краткое описание">{{ old('description') ? old('description') : $project->description }}</textarea>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="text" class="col-md-4 col-form-label text-md-end">Лидер</label>
                                <div class="col-md-6">
                                    <select id="leader_id" type="text"
                                            class="form-select @error('leader_id') is-invalid @enderror"
                                            name="leader_id">
                                        <option selected value="">—</option>
                                        @foreach ($users as $user)
                                            <option @if($project->leader_id == $user->id) selected
                                                    @endif value="{{ $user->id }}">
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('leader_id')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="place" class="col-md-4 col-form-label text-md-end">Одобрено</label>
                                <div class="col-md-6 align-items-center" style="display: flex">
                                    <div class="form-check">
                                        <input type='hidden' value='0' name='approved'>
                                        <input class="form-check-input" type="checkbox" value='1'
                                               @if($project->approved == 1) checked @endif name="approved">
                                    </div>
                                    @error('approved')
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
