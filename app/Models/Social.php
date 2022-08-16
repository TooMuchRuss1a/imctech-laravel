<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Social extends Model implements AuditableContract
{
    use HasFactory, Auditable;

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
        'type',
        'link',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'socials';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
