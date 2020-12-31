<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerDiscount extends Model
{
    public function voucher()
    {
        return $this->belongsTo('App\Voucher','voucher_id');
    }
}
