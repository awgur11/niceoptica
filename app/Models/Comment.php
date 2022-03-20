<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model {

    protected $table = "comments"; 

    protected $fillable = ['name', 'email', 'comment', 'page_id', 'advert_id', 'product_id', 'user_id', 'status', 'stars'];

    public function page()
    {
        return $this->belongsTo('App\Models\Page');
    }

    public function advert()
    {
        return $this->belongsTo('App\Models\Advert');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
