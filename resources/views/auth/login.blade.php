<x-guest-layout>
    <x-auth-card>
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" />

        <x-splade-form action="{{ route('login') }}" class="space-y-4" id="loginForm">
            <!-- Email Address -->
            <x-splade-input id="login" type="text" name="login" :label="'Логин'" required autofocus />
            <x-splade-input id="password" type="password" name="password" :label="__('Password')" required autocomplete="current-password" />
            <x-splade-checkbox id="remember_me" name="remember" :label="__('Remember me')" />

            <div class="flex items-center justify-end">
                @if (Route::has('password.request'))
                    <Link class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </Link>
                @endif

                <x-splade-submit class="ml-3 hidden" :label="__('Log in')" />
                    <div style="cursor: pointer" id="robot" class="rounded-md shadow-sm bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 focus:outline-none focus:shadow-outline ml-4" onclick="captcha()">
                        <div class="flex flex-row items-center justify-center">
                        <span>
                            <svg id="loading" style="margin-bottom: 4px; margin-right: 2px" aria-hidden="true" role="status" class="hidden inline w-4 h-4 mr-3 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
                                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
                            </svg>
                            Я не робот
                        </span>
                        </div>
                    </div>
            </div>
        </x-splade-form>
    </x-auth-card>
    @push('scripts')
        <script>
            setInterval(function () {
                if (window.location.pathname === "/login" && getCookie('recaptcha') === "") {
                    document.getElementById("loginForm").getElementsByTagName('button')[0].classList.add('hidden');
                    document.getElementById("robot").classList.remove('hidden');
                }
            }, 1 * 1000);

            function captcha() {
                document.getElementById("loading").classList.remove('hidden');
                grecaptcha.ready(function () {
                    grecaptcha.execute('{{ config('services.recaptcha.sitekey') }}', {action: 'register'})
                        .then(function (token) {
                            document.getElementById("robot").classList.add('hidden');
                            document.getElementById("loginForm").getElementsByTagName('button')[0].classList.remove('hidden')
                            document.getElementById("loading").classList.add('hidden');
                            setCookie('recaptcha', token, 0.1);
                        });
                });
            }
        </script>
    @endpush
</x-guest-layout>
