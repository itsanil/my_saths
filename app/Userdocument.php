<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Userdocument extends Model
{
    protected $table='user_document';
    
       protected $fillable = [
        'user_id',
        'proof',
        'document_type',
        'status',
    ];


}
