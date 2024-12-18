<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    protected $fillable = [
        'date', 'starting_time', 'tour_time', 'price', 'capacity', 'status', 'guide_id',
    ];

    public function bookings() {
        return $this->hasMany('App\Booking', 'tour_id', 'id');
    }

    public function guide() {
        return $this->belongsTo('App\Guide', 'guide_id', 'id');
    }

    public function tour_menu() {
        return $this->hasMany('App\Booking_Menu', 'tour_id', 'id');
    }
}
