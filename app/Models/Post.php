<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    protected $fillable = [
        'title',
        'description',
        'start',
        'end',
        'slug',
        'views',
        'active',
        'is_premium',
        'status',
        'user_id',
        'category_id',
        'state_id',
        'municipio_id',
        'plan_id',
    ];

    public function user(): BelongsTo
    {
        return  $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->BelongsTo(Category::class);
    }

    public function state(): BelongsTo
    {
        return $this->BelongsTo(State::class);
    }

    public function municipio(): BelongsTo
    {
        return $this->BelongsTo(Municipio::class);
    }

    public function plan(): BelongsTo
    {
        return $this->BelongsTo(Plan::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
