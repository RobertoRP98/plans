<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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


    public function post():HasMany{
        return $this->hasMany(Post::class);
    }

}
