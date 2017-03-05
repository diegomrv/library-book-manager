<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
	protected $dates = ['published_date'];

    /**
     * Category of a book
    **/
    public function category()
    {
    	return $this->belongsTo('App\Category');
    }


    /**
     * User borrowed a book
    **/
    public function user()
    {
    	return $this->belongsTo('App\User');
    }
}
