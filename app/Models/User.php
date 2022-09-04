<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    protected static function boot() {
        parent::boot();

        static::creating(function ($model) {
            $model->created_by = auth()->check() ? auth()->user()->id : 1;
            $model->updated_by = auth()->check() ? auth()->user()->id : 1;
        });

        static::updating(function ($model) {
            $model->updated_by = auth()->check() ? auth()->user()->id : 1;
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'login',
        'name',
        'agroup',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function socials()
    {
        return $this->hasMany('App\Models\Social');
    }

    public function role()
    {
        return $this->belongsTo('App\Models\Role', 'id', 'user_id');
    }

    public function activities()
    {
        return $this->hasMany('App\Models\Activity');
    }

    public function creator()
    {
        return $this->belongsTo('App\Models\User', 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo('App\Models\User', 'updated_by');
    }
}
