<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recipient extends Model
{
    protected $fillable = ['id', 'name', 'email'];
    protected $table = 'recipient';
    public $timestamps = false;
}
