<?php

namespace App\Providers;

use App\Models\Event;
use App\Models\User;
use App\Services\VkApiService;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('unique_email', function ($attribute, $value)
        {
            return User::where('email', $value)->whereNotNull('email_verified_at')->count() == 0;
        });

        Validator::extend('dvfu_email', function ($attribute, $value)
        {
            return strpos($value, 'dvfu.ru');
        });

        Validator::extend('name_russian', function ($attribute, $value)
        {
            return preg_match('/[^а-я ^ё]+/msiu', $value);
        });

        Validator::extend('recaptcha', function ($attribute, $value)
        {
            $data = array(
                'secret' => config('services.recaptcha.secret'),
                'response' => $value
            );
            $verify = curl_init();
            curl_setopt($verify, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
            curl_setopt($verify, CURLOPT_POST, true);
            curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
            $response = json_decode(curl_exec($verify),true);
            info($response);

            return $response['success'];
        });

        Validator::extend('register_actual', function ($attribute, $value)
        {
            if (!empty($event = Event::findOrFail($value))) {
                if (now() < $event->register_until) {
                    return true;
                }
            }
            return false;
        });

        Validator::extend('event_has_conversation', function ($attribute, $value)
        {
            if (!empty($event = Event::findOrFail($value))) {
                if (!empty($event->conversation_id)) {
                    return true;
                }
            }
            return false;
        });

        Validator::extend('email_verified', function ($attribute, $value)
        {
            if (!empty($user = User::findOrFail($value))) {
                if (!empty($user->email_verified_at)) {
                    return true;
                }
            }
            return false;
        });

        Validator::extend('valid_vk', function ($attribute, $value)
        {
            $vkApiService = new VkApiService();
            if (!empty($vkApiService->getVkDataViaLink($value))) {
                return true;
            }
            return false;
        });


        Blade::if('hasrole', function () {
            if (!empty(auth()->user()->role)) {
                return true;
            }

            return false;
        });
    }
}
