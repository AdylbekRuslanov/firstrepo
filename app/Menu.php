<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{

    protected $table = 'menu';

    protected $fillable = [
        'name',
    ];

    public function booking_menu() {
        return $this->hasMany('App\Booking_Menu', 'menu_id', 'id');
    }
}
