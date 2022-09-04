<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Services\VkApiService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = 'email/verify';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        request()->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users', 'dvfu_email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'recaptcha' => ['recaptcha'],
        ]);

        request()->validate([
            'vk' => ['required', 'string', 'valid_vk'],
        ]);

        return Validator::make($data, [
            'name' => ['required'],
            'email' => ['required'],
            'password' => ['required'],
            'vk' => ['required'],
            ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'login' => strtolower(explode("@", $data['email'])[0]),
            'email' => strtolower($data['email']),
            'name' => $data['name'],
            'agroup' => mb_strtoupper(mb_substr(str_replace(' ', '', $data['agroup']), 0, 1, 'UTF-8'), 'UTF-8') . mb_strtolower(mb_substr(str_replace(' ', '', $data['agroup']), 1, strlen(str_replace(' ', '', $data['agroup'])) - 1, 'UTF-8'), 'UTF-8'),
            'password' => bcrypt($data['password']),
        ]);

        $vkApiService = new VkApiService();
        $vk_id = $vkApiService->getVkDataViaLink($data['vk'])[0]['id'];
        $user->socials()->create([
            'type' => 'vk',
            'link' => 'https://vk.com/id'.$vk_id
        ]);

        return $user;
    }
}
