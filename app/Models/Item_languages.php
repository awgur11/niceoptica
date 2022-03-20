<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item_languages extends Model
{
    protected $table = 'items_languages';

    public $timestamps = false;
    
    protected $fillable = ['title', 'language', 'id_items', 'string1', 'string2', 'string3', 'text1', 'text2', 'text3'];
}
