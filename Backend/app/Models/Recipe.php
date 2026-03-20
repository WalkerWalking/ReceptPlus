<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    public $table = 'recipes';

    public $timestamps = false;

    public $guarded = [];

    public function ingredients()
    {
        return $this->belongsToMany(
            Ingredients::class,
            'ingredient_recipe',
            'recipeId',
            'ingredientId'
        )->withPivot('amount');
    }
    
    
}
