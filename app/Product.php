<?php

namespace App;
use App\Location;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'code', 'location_new', 'description', 'status', 'pickup'];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function location() {
        return $this->belongsTo(Location::class, 'location_id');
    }
}
