<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    protected $fillable = ['name', 'order', 'funnel_id'];

    public function funnel()
    {
        return $this->belongsTo(Funnel::class, 'funnel_id', 'id');
    }

    public function contacts()
    {
        return $this->hasMany(Contacts::class, 'stage_id');
    }

}
