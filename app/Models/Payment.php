<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';

    protected $fillable = ['user_id','post_id','plan_id', 'payment_id','status','amount','payload'];
    
}
