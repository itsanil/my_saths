<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    public function brand()
    {
        return $this->belongsTo('App\Brand','brand_id');
    }
}
