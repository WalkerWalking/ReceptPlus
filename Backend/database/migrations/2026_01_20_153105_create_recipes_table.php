<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('userId')->references('id')->on('users')->cascadeOnDelete();;
            $table->text('imageUrl')->nullable();
            $table->boolean('isMakeable')->default(false);
            $table->text('description')->nullable();
            $table->integer('calories')->default(0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recipes');
    }
};
