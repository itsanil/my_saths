<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    public function areas()
    {
        return $this->belongsTo('App\Area','area_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }
}
