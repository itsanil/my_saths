<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReturnStockLog extends Model
{
   	public function product()
    {
        return $this->belongsTo('App\Product','product_id');
    }
}