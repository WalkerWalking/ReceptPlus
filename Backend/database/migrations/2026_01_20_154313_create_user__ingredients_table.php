<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_ingredient', function (Blueprint $table) {
            $table->primary(['userId', 'ingredientId']);
            $table->foreignId('userId')->references('id')->on('users')->cascadeOnDelete();
            $table->foreignId('ingredientId')->references('id')->on('ingredients')->cascadeOnDelete();
            $table->integer('amount');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_ingredient');
    }
};
