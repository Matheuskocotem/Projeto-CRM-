<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Contacts extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'funnel_id',
        'stage_id',
        'email',
        'phoneNumber',
        'dateOfBirth',
        'address',
        'buyValue',
    ];

    public function funnel()
    {
        return $this->belongsTo(Funnel::class, 'funnel_id');
    }
}