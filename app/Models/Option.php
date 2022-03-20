<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model {

    protected $table = "option";

    protected $fillable = ['key', 'preview_path', 'preview_name', 'value', 'type', 'place', 'thumbs', 'extension'];

	public $timestamps = false;

    public function languages()
    {
        return $this->hasMany('App\Models\Option_languages');
    }

    public function language()
    {
        return $this->hasOne('App\Models\Option_languages')->where('language', \App::getLocale());
    }
}
