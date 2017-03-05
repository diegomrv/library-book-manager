<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    /**
     * Books of a category
    **/
    public function books()
    {
    	return $this->hasMany('App\Book');
    }
}
