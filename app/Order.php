<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function customer()
    {
        return $this->belongsTo('App\Customer','customer_id');
    }

    public function product()
    {
        return $this->belongsTo('App\Product','product_id');
    }

    public function PaymentType()
    {
        return $this->belongsTo('App\PaymentType','payment_type_id');
    }

    
}
