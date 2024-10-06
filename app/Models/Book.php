<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
class Book extends Model
{
    use HasFactory,Notifiable;

    protected $fillable=['title','author','isbn','genre'];
    
    public function rentals(){
        return $this->hasMany(Rentals::class);
    }
}
