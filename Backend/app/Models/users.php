<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class users extends Model
{
    use HasFactory;
    public $table = 'users';
    public $timestamps = false;
    public $guarded = [];    

    public function ingredients()
    {
    return $this->belongsToMany(Ingredients::class, 'user_ingredient', 'userId', 'ingredientId')
        ->withPivot('amount');
    }
}
