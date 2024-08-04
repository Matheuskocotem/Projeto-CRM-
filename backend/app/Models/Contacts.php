<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contacts extends Model
{
    use HasFactory;
    protected $table = 'contacts';
    protected $fillable = [
        'position', 'name', 'email', 'phoneNumber', 'dateOfBirth', 'address', 'buyValue', 'funnel_id', 'stage_id'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $maxposition = static::max('position');
            $model->position = $maxposition + 1;
        });
    }

    public function funnel()
    {
        return $this->belongsTo(Funnel::class, 'funnel_id');
    }

    public function stage()
    {
        return $this->belongsTo(Stage::class, 'stage_id');
    }

    public static function getNextPosition($stage_id)
    {
        $lastPosition = self::where('stage_id', $stage_id)->max('position');
        return $lastPosition ? $lastPosition + 1 : 1;
    }
}

