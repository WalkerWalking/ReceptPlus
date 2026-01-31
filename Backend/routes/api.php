<?php
 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\IngredientsController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\INgredientRecipeController;
use App\Http\Controllers\UserIngredientController;

/*==================================================
||               ALAP HTTP METÓDUSOK               ||
==================================================*/

/*--------------------------------------------------
||             User Controller                     ||
||             Alap HTTP metódusok                 ||
--------------------------------------------------*/
Route::get('/users', [UsersController::class, 'index']);
Route::post('/users', [UsersController::class, 'store']);
Route::put('/users/{userId}', [UsersController::class, 'update']);
Route::delete('/users/{userId}', [UsersController::class, 'destroy']);

/*--------------------------------------------------
||          User Ingredients Controller            ||
||          Alap HTTP metódusok                   ||
--------------------------------------------------*/
Route::get('/usersIngredients', [UserIngredientController::class, 'index']);
Route::post('/usersIngredients', [UserIngredientController::class, 'store']);
Route::put('/usersIngredients/{userId}/{ingredientId}', [UserIngredientController::class, 'update']);
Route::delete('/usersIngredients/{userId}/{ingredientId}', [UserIngredientController::class, 'destroy']);


/*--------------------------------------------------
||          Recepies Controller                   ||
||          Alap HTTP metódusok                   ||
--------------------------------------------------*/
Route::get('/recipes', [RecipeController::class, 'index']);        // összes recept (userhez)
Route::post('/recipes', [RecipeController::class, 'store']);       // új recept
Route::put('/recipes/{id}', [RecipeController::class, 'update']);  // recept frissítés
Route::delete('/recipes/{recipetId}', [RecipeController::class, 'destroy']); // recept törlés


/*--------------------------------------------------
||          Comments Controller                   ||
||          Alap HTTP metódusok                   ||
--------------------------------------------------*/
Route::get('/comments', [CommentController::class, 'index']);
Route::post('/comments', [CommentController::class, 'store']);
Route::put('/comments/{id}', [CommentController::class, 'update']);
Route::delete('/comments/{id}', [CommentController::class, 'destroy']);


/*--------------------------------------------------
||          Ingredients Controller                 ||
||          Alap HTTP metódusok                   ||
--------------------------------------------------*/
Route::get('/ingredients', [IngredientsController::class, 'index']);        // összes
Route::post('/ingredients', [IngredientsController::class, 'store']);      // létrehozás
Route::put('/ingredients/{id}', [IngredientsController::class, 'update']); // frissítés
Route::delete('/ingredients/{id}', [IngredientsController::class, 'destroy']); // törlés


/*--------------------------------------------------
||          Ingredients Recipes Controller                 ||
||          Alap HTTP metódusok                   ||
--------------------------------------------------*/
Route::get('/ingredient-recipe', [IngredientRecipeController::class, 'index']); // összes recept + hozzávaló
Route::post('/ingredient-recipe', [IngredientRecipeController::class, 'store']); // új kapcsolat
Route::put('/ingredient-recipe/{ingredientId}/{recipeId}', [IngredientRecipeController::class, 'update']); // frissítés
Route::delete('/ingredient-recipe/{ingredientId}/{recipeId}', [IngredientRecipeController::class, 'destroy']); // törlés


/*==================================================
||              CUSTOM HTTP METÓDUSOK              ||
==================================================*/

/*--------------------------------------------------
||          User Controller                        ||
||          Speciális lekérdezések                 ||
--------------------------------------------------*/
Route::get('/users/getbyId/{userId}', [UsersController::class, 'getbyId']);
Route::get('/users/MoreThan_bodyweightKg/{value}', [UsersController::class, 'MoreThan_bodyweightKg']);
Route::get('/users/LessThan_bodyweightKg/{value}', [UsersController::class, 'LessThan_bodyweightKg']);
Route::get('/users/hasFilter_profilePictureUrl', [UsersController::class, 'hasFilter_profilePictureUrl']);

/*--------------------------------------------------
||          User Ingredients Controller            ||
||          Speciális lekérdezések                 ||
--------------------------------------------------*/
Route::get('/usersIngredients/getById/{userId}/{ingredientId}', [UserIngredientController::class, 'getById']);


/*--------------------------------------------------
||          Recipe Controller                     ||
||          Speciális lekérdezések                 ||
--------------------------------------------------*/
Route::get('/recipes/getbyId/{recipeId}', [RecipeController::class, 'getbyId']);

/*--------------------------------------------------
||          Comments Controller                     ||
||          Speciális lekérdezések                 ||
--------------------------------------------------*/
Route::get('/comments/getById/{id}', [CommentController::class, 'getById']);
Route::get('/comments/recipe/{recipeId}', [CommentController::class, 'getByRecipeId']);
Route::get('/comments/user/{userId}', [CommentController::class, 'getByUserId']);

/*--------------------------------------------------
||          Ingredients Controller                 ||
||          Speciális lekérdezések                 ||
--------------------------------------------------*/
Route::get('/ingredients/getById/{id}', [IngredientsController::class, 'getById']); // ID alapján
Route::get('/ingredients/fruits', [IngredientsController::class, 'getFruits']);         // csak gyümölcsök
Route::get('/ingredients/non-fruits', [IngredientsController::class, 'getNonFruits']);  // nem gyümölcsök
Route::get('/ingredients/kcal/more-than/{value}', [IngredientsController::class, 'MoreThan_kcalPerGram']); // kcal/gram > value
Route::get('/ingredients/kcal/less-than/{value}', [IngredientsController::class, 'LessThan_kcalPerGram']); // kcal/gram < value


/*--------------------------------------------------
||          Ingredients Recepie Controller         ||
||          Speciális lekérdezések                 ||
--------------------------------------------------*/
Route::get('/ingredient-recipe/recipe/{recipeId}', [IngredientRecipeController::class, 'getByRecipe']); // egy recept hozzávalói