<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class INgredient_Recipe extends Pivot
{
    use HasFactory;
    public $table = 'ingredient_recipe';
    public $timestamps = false;
    public $guarded = [];
    public $incrementing = false;
}
