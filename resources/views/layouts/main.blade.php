<x-app-layout>
    <x-slot name="header">
        <div class="flex h-16">
        <div class="hidden space-x-8 ml-4 sm:flex">
            <x-nav-link :href="route('service.activity')" :active="request()->routeIs('service.activity')">
                Записаться на мероприятие
            </x-nav-link>
        </div>
        <div class="hidden space-x-8 ml-4 sm:flex">
            <x-nav-link :href="route('service')" :active="request()->routeIs('cases')">
                Кейсы
            </x-nav-link>
        </div>
        <div class="hidden space-x-8 ml-4 sm:flex">
            <x-nav-link :href="route('service.projects')" :active="request()->routeIs('service.projects')">
                Проекты
            </x-nav-link>
        </div>
        <div class="hidden space-x-8 ml-4 sm:flex">
            <x-nav-link :href="route('service')" :active="request()->routeIs('teams')">
                Команды
            </x-nav-link>
        </div>
        </div>
    </x-slot>
    @yield('main')
</x-app-layout>
