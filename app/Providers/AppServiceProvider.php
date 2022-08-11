<?php

namespace App\Providers;

use App\Models\User;
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
    }
}
