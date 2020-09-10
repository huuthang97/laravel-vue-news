<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded = [];

    public function category() {
        return $this->belongsTo('App\Category');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Tag', 'tag_post', 'post_id', 'tag_id');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
