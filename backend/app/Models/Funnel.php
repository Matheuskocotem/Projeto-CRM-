<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Funnel extends Model
{
    use HasFactory;

    protected $table = 'funnel';

    protected $fillable = ['user_id', 'name', 'color'];
    
    protected static function booted()
    {
        static::created(function ($funnel) {
            $stages = ['sem etapa', 'prospecção', 'contato', 'proposta'];

            foreach ($stages as $index => $stageName) {
                \App\Models\Stage::create([
                    'funnel_id' => $funnel->id,
                    'name' => $stageName,
                    'order' => $index + 1,
                ]);
            }
        });
    }

    // Relacionamento com o usuário
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function stages()
    {
        return $this->hasMany(Stage::class, 'funnel_id');
    }

    public function contacts()
    {
        return $this->hasMany(Contacts::class);
    }
}
