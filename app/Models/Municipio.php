<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Municipio extends Model
{
    protected $fillable = ['name', 'state_id', 'active'];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function post():BelongsTo{
        return $this->belongsTo(Post::class);
    }
}
