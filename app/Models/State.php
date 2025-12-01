<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class State extends Model
{
    protected $fillable = ['name','slug'];

    public function municipios(): HasMany
    {
        return $this->hasMany(Municipio::class);
    }

   public function post():HasMany{
    return $this->hasMany(Post::class);
   }
}
