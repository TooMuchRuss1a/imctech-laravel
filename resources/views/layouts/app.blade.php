<div class="min-h-screen bg-gray-100">
    <div id="cookieNotice" class="flex items-center justify-between border-b p-3" style="background-color: #b6d4fe; display: none">
        <div></div>
        <div class="text-base" style="color: #084298">Мы используем cookie! Оставаясь на сайте, вы соглашаетесь с <a href="{{route('privacy')}}" class="font-medium text-blue-600 dark:text-blue-500 underline">Политикой в отношении обработки персональных данных</a></div>
        <div class="flex items-center space-x-5 text-gray-100">
            <button onclick="acceptCookie()" type="button" class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                <span class="sr-only">Close menu</span>
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>
    @include('layouts.navigation')
    @if(session('modal'))
        <div class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true" id="modal">
            <div class="fixed inset-0 transition-opacity" style="background-color: black; opacity: 0.75;"></div>
            <div class="fixed inset-0 z-10 overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                    <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">Остается только</h3>
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-500">Вступить в беседу ВК - <a rel="noopener noreferrer" target="_blank" class="font-medium underline" style="color: #0c63e4" href="{{session('modal')}}">{{session('modal')}}</a></p>
                                        <p class="text-sm text-gray-500">Подписаться на телегам канал - <a rel="noopener noreferrer" target="_blank" class="font-medium underline" style="color: #0c63e4" href="https://t.me/imctech">https://t.me/imctech</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                            <button type="button" class="mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:mt-0 sm:w-auto sm:text-sm" onclick="document.getElementById('modal').classList.add('hidden');">Сделано</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Page Heading -->
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{ $header }}
        </div>
    </header>

    <!-- Page Content -->
    <main>
        {{ $slot }}
    </main>
    <!-- Foooter -->
    <section>
        <div class="max-w-screen-xl px-4 py-12 mx-auto space-y-8 overflow-hidden sm:px-6 lg:px-8 content-center">
            <nav class="flex flex-wrap justify-center -mx-5 -my-2">
                <div class="px-5 py-2">
                    <a class="text-sm leading-6 text-gray-500 hover:text-gray-900" href="{{route('privacy')}}">Политика в отношении персональных данных</a>
                </div>
            </nav>
            <hr style="width: 30%;" class="mt-4 mx-auto">
            <p class="mt-2 text-xs leading-6 text-center text-gray-400">
                IMCTechService
            </p>
        </div>
    </section>
</div>
