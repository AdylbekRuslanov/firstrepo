<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking_Menu extends Model
{
    protected $table = 'booking_menu';

    protected $fillable = [
        'menu_id', 'tour_id', 'quantity'
    ];

    public function tour_menu() {
        return $this->belongsTo('App\Tour', 'tour_id', 'id');
    }

    public function menu() {
        return $this->belongsTo('App\Menu', 'menu_id', 'id');
    }
}
