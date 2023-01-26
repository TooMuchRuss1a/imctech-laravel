<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Rules\Recaptcha;
use App\Services\VkApiService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use ProtoneMedia\Splade\Facades\Toast;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $cookies = $request->cookies->all();
        Cookie::queue('recaptcha', "", 0);
        $validator = Validator::make($cookies, [
            'recaptcha' => ['required', new Recaptcha()],
        ])->messages();

        if (!empty($validator->messages())) {
            Toast::title('Похоже, что вы робот')
                ->danger();
            throw ValidationException::withMessages([
                $validator->messages()['recaptcha']
            ]);
        }


        if (in_array($request->agroup[0], ['C', 'c']))
            $request->merge(
                [
                    'agroup' => str_replace('C', 'С', str_replace('c', 'С', request()->agroup))
                ]
            );

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users', 'dvfu_email'],
            'agroup' => ['agroup'],
            'password' => ['required', 'string', 'min:8', 'confirmed', Rules\Password::defaults()],
        ]);

        $vk = $request->validate([
            'vk' => ['required', 'string', 'valid_vk'],
        ]);

        $user = User::create([
            'login' => strtolower(explode("@", $validated['email'])[0]),
            'email' => strtolower($validated['email']),
            'name' => $validated['name'],
            'agroup' => mb_strtoupper(mb_substr(str_replace(' ', '', $validated['agroup']), 0, 1, 'UTF-8'), 'UTF-8') . mb_strtolower(mb_substr(str_replace(' ', '', $validated['agroup']), 1, strlen(str_replace(' ', '', $validated['agroup'])) - 1, 'UTF-8'), 'UTF-8'),
            'password' => bcrypt($validated['password']),
        ]);

        $vkApiService = new VkApiService();
        $vk_id = $vkApiService->getVkDataViaLink($vk['vk'])[0]['id'];
        $user->socials()->create([
            'type' => 'vk',
            'link' => 'https://vk.com/id'.$vk_id
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
