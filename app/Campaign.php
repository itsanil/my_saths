<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    public function campaign()
    {
        return $this->belongsTo('App\CampaignCategory','category_id');
    }
}
