<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ingredient_recipe', function (Blueprint $table) {
            $table->primary(['ingredientId','recipeId']);
            $table->foreignId('ingredientId')->references('id')->on('ingredients')->cascadeOnDelete();
            $table->foreignId('recipeId')->references('id')->on('recipes')->cascadeOnDelete();            
            $table->integer('amount');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ingredient_recipe');
    }
};
