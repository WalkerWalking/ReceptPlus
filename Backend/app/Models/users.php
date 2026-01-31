<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class users extends Model
{
    //Ez a jó model a userekhez
    use HasFactory;
    public $table = 'users';
    public $timestamps = false;
    public $guarded = [];    

}
