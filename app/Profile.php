<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use willvincent\Rateable\Rateable;

class Profile extends Model
{
    use Rateable; //https://github.com/willvincent/laravel-rateable

    protected $fillable = [
        'addressLineOne',
        'addressLineTwo',
        'city',
        'state',
        'country',
        'pincode',
        'bio',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    // $user = User::firstOrNew(array('name' => Input::get('name')));
    // $user->foo = Input::get('foo');
    // $user->save();
}
