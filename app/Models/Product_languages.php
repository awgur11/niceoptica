<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product_languages extends Model
{
    protected $table = 'products_languages';

    public $timestamps = false;
    
    protected $fillable = ['title', 'product_id', 'language', 'params', 'shot_content', 'content', 'specification', 'tag_title', 'description'];
}
