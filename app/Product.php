<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function ProductSource()
    {
        return $this->belongsTo('App\ProductSource','product_source_id');
    }
}
