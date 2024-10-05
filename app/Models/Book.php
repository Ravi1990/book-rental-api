<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable=['title','author','isbn','genre'];
    
    public function rentals(){
        return $this->hasMany(Rentals::class);
    }
}
