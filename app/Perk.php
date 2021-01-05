<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Perk extends Model
{
	protected $table = "campaign_perks";

	
    public function campaigns()
    {
        return $this->belongsTo('App\Campaign','campaign_id');
    }
}
