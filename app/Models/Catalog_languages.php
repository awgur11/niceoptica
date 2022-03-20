<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Catalog_languages extends Model
{
    protected $table = 'catalogs_languages';

    public $timestamps = false;
    
    protected $fillable = ['title', 'menu', 'language', 'catalog_id', 'tag_title', 'description', 'content', 'params'];
}
