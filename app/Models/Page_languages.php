<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page_languages extends Model
{
    protected $table = 'pages_languages';

    public $timestamps = false;
    
    protected $fillable = ['menu', 'title', 'shot_content', 'content', 'language', 'page_id', 'tag_title', 'description'];
 
    public function page()
    {
        return $this->belongsTo('App\Models\Page');
    }

}
