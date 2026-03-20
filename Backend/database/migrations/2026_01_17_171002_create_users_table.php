<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('passwrd');
            $table->string('email')->unique();
            $table->string('name');
            $table->string('username')->unique();
            $table->integer('bodyweightKg')->nullable();
            $table->integer('heightCm')->nullable();
            $table->date('birthDate')->default(DB::raw('CURRENT_TIMESTAMP'))->nullable();
            $table->text('profilePictureUrl')->nullable();
            $table->integer('caloriesEaten')->default(0);
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
