<?php

namespace Dsc;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $fillable = ['author_id', 'post_title', 'slug', 'description'];

    public function author()
    {
        return $this->belongsTo(User::class);
    }
    public function parent()
    {
        return $this->belongsTo('Category', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany('Category', 'parent_id');
    }
}
