<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductMaster extends Model
{
    public function brand()
    {
        return $this->belongsTo('App\Brand','brand_id');
    }
}
