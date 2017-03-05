<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    /**
     * Category of a book
    **/
    public function category()
    {
    	return $this->belongsTo('App\Category');
    }
}
