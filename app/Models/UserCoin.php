<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCoin extends Model
{ 
    protected $table = 'coin_user';

    protected $fillable = ['user_id', 'coin_id'];

    public function coin()
    {
        return $this->belongsTo(Coin::class, 'coin_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

