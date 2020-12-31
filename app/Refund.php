<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{
    public function customer()
    {
        return $this->belongsTo('App\Customer','customer_id');
    }

    public function order()
    {
        return $this->belongsTo('App\Order','order_id');
    }
}
