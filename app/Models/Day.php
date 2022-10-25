<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Day extends Model implements AuditableContract
{
    use HasFactory, Auditable;

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
        'date',
        'name',
        'place'
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'timetable_days';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    protected $dates = [
        'date'
    ];

    public function timelines()
    {
        return $this->hasMany('App\Models\Timeline')->orderBy('from');
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
