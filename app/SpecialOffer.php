<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpecialOffer extends Model
{
    protected $fillable = ['id', 'name', 'discount'];
    protected $table = 'special_offer';
    public $timestamps = false;
}
