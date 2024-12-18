<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Guide extends Model
{
    protected $fillable = [
        'name',
    ];

    public function tours() {
        return $this->hasMany('App\Tour', 'guide_id', 'id');
    }
}
