<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use willvincent\Rateable\Rateable;

class Listing extends Model
{
    use Rateable; // https://github.com/willvincent/laravel-rateable

    protected $fillable = [
        'title',
        'addressLineOne',
        'addressLineTwo',
        'city',
        'state',
        'country',
        'pincode',
        'latitude',
        'longitude',
        'thumbnail',
        'price',
        'description',
        'user_id',
        'category_id',
        'is_featured',
        'is_active'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function category()
    {
        return $this->belongsTo('App\Category');
    }
}
