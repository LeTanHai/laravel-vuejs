<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    //
    protected $fillable = ['origin', 'destination'];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

}
