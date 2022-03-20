<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Picture_languages extends Model
{
    protected $table = 'pictures_languages';

    public $timestamps = false;
    
    protected $fillable = ['title', 'picture_id', 'language'];
}
