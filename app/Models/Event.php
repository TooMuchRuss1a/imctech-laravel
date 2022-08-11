<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected static function boot() {
        parent::boot();

        static::creating(function ($model) {
            $model->created_by = auth()->check() ? auth()->guard(config('app.guards.web'))->user()->id : 1;
            $model->updated_by = auth()->check() ? auth()->guard(config('app.guards.web'))->user()->id : 1;
        });

        static::updating(function ($model) {
            $model->updated_by = auth()->check() ? auth()->guard(config('app.guards.web'))->user()->id : 1;
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'register_until',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'events';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    public function activities()
    {
        return $this->hasMany('App\Models\Activity');
    }
}
