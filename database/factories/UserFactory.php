<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    public $alphabet = 'АБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯ';
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $login = explode('@', $this->faker->unique()->safeEmail())[0];
        return [
            'login' => $login,
            'email' => $login . '@testuser.dvfu.ru',
            'agroup' => mb_substr($this->alphabet, rand(0, mb_strlen($this->alphabet, 'UTF-8')-1), 1, 'UTF-8') .now()->format('Y-H.i.s'). mb_strtolower(mb_substr($this->alphabet, rand(0, mb_strlen($this->alphabet, 'UTF-8')-5), rand(0, 4), 'UTF-8'), 'UTF-8'),
            'name' => $this->faker->name(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
