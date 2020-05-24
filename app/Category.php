<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    protected $fillable = [
        'name',
        'parent_id'
    ];

    public function listings()
    {
        return $this->hasMany('App\Listing');
    }

    public function parent() {
        return $this->belongsTo('App\Category', 'parent_id'); //get parent category
    }
    
    public function children() {
        return $this->hasMany('App\Category', 'parent_id'); //get all subs. NOT RECURSIVE
    }
}
