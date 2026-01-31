<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use App\Models\Ingredients;

class User_Ingredient extends Model
{
    use HasFactory;
    public $table = 'user_ingredient';
    public $timestamps = false;
    public $guarded = [];
    public $incrementing = false;

    public function ingredient()
    {
        return $this->belongsTo(Ingredients::class, 'ingredientId');
    }

    public function recipe()
    {
        return $this->belongsTo(Recipe::class, 'recipeId');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }

    
}
