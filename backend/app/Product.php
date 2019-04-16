<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function products() {
        return $this->belongsTo('App\User');
    }
}
