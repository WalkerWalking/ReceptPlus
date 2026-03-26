<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\users;
use App\Models\Ingredients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RecipeController extends Controller
{
    public function index()
    {
        return Recipe::all();
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'userId' => 'required|integer|exists:users,id',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'ingredients' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Hibás adatokat küldtél.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $imageUrl = null;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('recipeImages', 'public');
            $imageUrl = asset('storage/'.$path);
        }

        $recipe = Recipe::create([
            'name' => $request->name,
            'userId' => $request->userId,
            'description' => $request->description,
            'imageUrl' => $imageUrl,
            'isMakeable' => 0,
            'calories' => 0,
        ]);

        $ingredients = json_decode($request->ingredients, true);

        $totalCalories = 0;

        foreach ($ingredients as $ingredient) {
            $recipe->ingredients()->attach($ingredient['id'], [
                'amount' => $ingredient['amount'],
            ]);

            $dbIngredient = Ingredients::find($ingredient['id']);
            if ($dbIngredient) {
                $totalCalories += $dbIngredient->kcalPerGram * $ingredient['amount'];
            }
        }

        $recipe->calories = round($totalCalories);
        $recipe->save();

        return response()->json([
            'message' => 'Recept sikeresen létrehozva.',
            'recipe' => $recipe,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $recipe = Recipe::where('id', '=', $id)->first();

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'sometimes|required|string|max:255',
                'imageUrl' => 'nullable|string',
            ]
        );

        if ($validator->fails()) {
            return response()->json(
                ['Hiba!' => 'Adatmegadási hiba!'],
                401
            );
        }

        $recipe->update($request->all());

        return response()->json($recipe);
    }

    public function destroy($recipeId)
    {
        $recipe = Recipe::find($recipeId);

        if (! $recipe) {
            return response()->json([
                'Hiba!' => 'Nincs ilyen recept az adatbázisban!',
            ], 404);
        }

        $recipe->delete();

        return response()->json([
            'Siker!' => 'Ez a recept sikeresen törölve!',
        ], 200);
    }

    public function getbyId($recipeId)
    {
        $searched = Recipe::where('id', '=', $recipeId)->first();

        if (is_null($searched)) {
            return response()->json(
                ['Hiba!' => 'Nincs ilyen recept ezzel az Id-val!'],
                404
            );
        }

        return response()->json($searched, 200);
    }

    public function getRecipeWithIngredients($recipeId)
    {
        $recipe = Recipe::with('ingredients')->find($recipeId);

        return response()->json([
            'id' => $recipe->id,
            'name' => $recipe->name,
            'userId' => $recipe->userId,
            'imageUrl' => $recipe->imageUrl,
            'ingredients' => $recipe->ingredients->map(function ($ingredient) {
                return [
                    'ingredientId' => $ingredient->id,
                    'ingredientName' => $ingredient->name,
                    'amount' => $ingredient->pivot->amount,
                ];
            }),
        ]);
    }

    public function getAllRecipesWithIngredients()
    {
        $recipes = Recipe::with('ingredients')->get();

        return response()->json($recipes);
    }

    public function getRecipesByUserId($userId)
    {
        $recipes = Recipe::where('userId', '=', $userId)->with('ingredients')->get();

        return response()->json($recipes);
    }

    public function makeRecipe($userId, $recipeId)
    {
        $user = users::find($userId);
        $recipe = Recipe::with('ingredients')->find($recipeId);

        if (! $user) {
            return response()->json([
                'message' => 'A funkció eléréséhez jelentkezz be!',
            ], 404);
        }

        if (! $recipe) {
            return response()->json([
                'message' => 'Recept nem található!',
            ], 404);
        }

        DB::beginTransaction();

        try {

            foreach ($recipe->ingredients as $recipeIngredient) {
                $userIngredient = DB::table('user_ingredient')
                    ->where('userId', $user->id)
                    ->where('ingredientId', $recipeIngredient->id)
                    ->first();

                if (! $userIngredient) {
                    continue;
                }

                $remainingAmount = $userIngredient->amount - $recipeIngredient->pivot->amount;

                if ($remainingAmount <= 0) {
                    DB::table('user_ingredient')
                        ->where('userId', $user->id)
                        ->where('ingredientId', $recipeIngredient->id)
                        ->delete();
                } else {
                    DB::table('user_ingredient')
                        ->where('userId', $user->id)
                        ->where('ingredientId', $recipeIngredient->id)
                        ->update([
                            'amount' => $remainingAmount,
                        ]);
                }
            }

            $recipeCalories = $this->calculateRecipeCalories($recipe);
            $user->caloriesEaten = ($user->caloriesEaten ?? 0) + $recipeCalories;
            $user->save();

            DB::commit();

            $remainingIngredients = DB::table('user_ingredient')
                ->join('ingredients', 'ingredients.id', '=', 'user_ingredient.ingredientId')
                ->where('user_ingredient.userId', $user->id)
                ->select(
                    'ingredients.id',
                    'ingredients.name',
                    'ingredients.unit',
                    'user_ingredient.amount'
                )
                ->get();

            return response()->json([
                'user' => $user,
                'remainingIngredients' => $remainingIngredients,
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Hiba történt a recept elkészítése közben',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    private function calculateRecipeCalories(Recipe $recipe): int
    {
        $totalCalories = 0;

        foreach ($recipe->ingredients as $ingredient) {
            $amount = $ingredient->pivot->amount;
            $kcalPerUnit = $ingredient->kcalPerGram;

            $totalCalories += $amount * $kcalPerUnit;
        }

        return (int) round($totalCalories);
    }
}
