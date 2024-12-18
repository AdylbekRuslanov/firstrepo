<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'names', 'reserved_number', 'attended_number', 'user_id', 'tour_id',
    ];

    public function user() {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function tour() {
        return $this->belongsTo('App\Tour', 'tour_id', 'id');
    }
}
