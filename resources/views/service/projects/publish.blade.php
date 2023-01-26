@extends('layouts.landing.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Подготовка к публикации проекта</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('projects.publish', ['id' => $project->id]) }}"
                              enctype="multipart/form-data">
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
                                <label for="subname" class="col-md-4 col-form-label text-md-end">Тематика</label>
                                <div class="col-md-6">
                                    <input id="subname" type="text"
                                           class="form-control @error('subname') is-invalid @enderror" name="subname"
                                           value="{{ old('subname') ? old('subname') : $project->subname }}" required
                                           autocomplete="off" placeholder="GameDev">
                                    @error('subname')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end">Десктопное
                                    изображение</label>
                                <div class="col-md-6">
                                    <input class="form-control @error('image_d') is-invalid @enderror" type="file"
                                           id="image_d" name="image_d" @if(!$project->image_d) required @endif>
                                    @error('image_d')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end">Мобильное
                                    изображение</label>
                                <div class="col-md-6">
                                    <input class="form-control @error('image_m') is-invalid @enderror" type="file"
                                           id="image_m" name="image_m" @if(!$project->image_m) required @endif>
                                    @error('image_m')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <textarea id="text" name="text" hidden>
                                {{ old('text') ? old('text') : ($project->text ? : 'Здесь должен быть текст, который будет описывать проект на странице <a href="https://imctech.ru/pschool">imctech.ru/pschool</a> - там же есть примеры') }}
                            </textarea>
                            <script>
                                tinymce.init({
                                    selector: 'textarea',
                                    plugins: 'link paste',
                                    menubar: false,
                                    toolbar: 'undo redo | bold italic | link | removeformat',
                                    paste_as_text: true,
                                    language: 'ru',
                                    extended_valid_elements: false,
                                    valid_elements: 'a[*],p[*],ul[*],li[*],em[*],strong[*]',
                                    invalid_elements: "script,object,embed,link,style,form,input,iframe",
                                    link_class_list: [
                                        {title: 'Ссылка', value: 'link'},
                                    ],
                                    setup: function (editor) {
                                        editor.on('change', function () {
                                            document.getElementById("text").value = tinymce.activeEditor.getContent({format: 'raw'});
                                        });
                                    },
                                });
                            </script>
                            <div class="row mb-0 mt-2">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" name="Submit" class="btn btn-primary">Отправить на
                                        рассмотрение
                                    </button>
                                </div>
                            </div>
                            <div class="row mb-0 mt-2">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" name="Submit" value="show" class="btn btn-outline-secondary"
                                            formtarget="_blank">Как будет выглядеть
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
