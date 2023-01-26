@extends('layouts.main')
@section('main')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <x-splade-form action="{{ route('service.activity') }}" class="space-y-4">
                        @csrf
                        <x-splade-select name="event_id" :options="$events" option-label="name" option-value="id" />

                        <div class="flex items-center justify-end">
                            <x-splade-submit class="ml-3" :label="'Записаться'" />
                        </div>
                    </x-splade-form>
                </div>
            </div>
        </div>
    </div>
@endsection
