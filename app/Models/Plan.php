<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Plan extends Model
{
    protected $fillable = [
        'name',
        'description',
        'duration',
        'price',
        'active',
        'priority'
    ];

    protected $casts = ['active' => 'boolean'];


    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
