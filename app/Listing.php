<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use willvincent\Rateable\Rateable;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Listing extends Model implements HasMedia
{
    use Rateable; // https://github.com/willvincent/laravel-rateable
    use HasMediaTrait;

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

    public function getPath(){
        $paths = [];
        $this->getMedia()->each(function ($image) {
            $paths[] = $image->getPath();
            Log::debug('An informational message.');
        });

        return $paths;
    }

    public function getUrl(){
        // $urls = [];
        // $this->getMedia()->each(function ($image) {
        //    $urls[] = $image->getUrl();
        //    //Log::debug($urls);
        // });

        // return $urls;

        return $this->getMedia()->map(function ($image) {
            return $image->getUrl();
        });
    }

    public function getMediaItems(){
        return $this->getMedia()->map(function ($image) {
           return  [
                "id" => $image->id,
                "name" => $image->name,
                "url" =>  $image->getUrl(),
            ];

        });

        return $paths;
    }
}
