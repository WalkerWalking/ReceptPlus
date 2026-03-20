<?php

namespace App\Http\Controllers;

use App\Models\Ingredient_Recipe;
use Illuminate\Http\Request;
use App\Models\Ingredients;
use App\Models\Recipe;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class IngredientRecipeController extends Controller
{
    public function index()
    {
        $recipes = DB::table('ingredient_recipe as ir')
            ->join('recipes as r', 'ir.recipeId', '=', 'r.id')
            ->join('ingredients as i', 'ir.ingredientId', '=', 'i.id')
            ->select(
                'r.id as recipeId',
                'r.name as recipeName',
                'i.id as ingredientId',
                'i.name as ingredientName',
                'ir.amount'
            )
            ->orderBy('r.name')
            ->get();

        if ($recipes->isEmpty()) {
            return response()->json(
                ["Hiba!" => "Nincs egyetlen hozzávaló sem recepthez rendelve!"],
                404
            );
        }

        return response()->json($recipes, 200);
    }


    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'recipeId' => 'required',
                'ingredientId' => 'required',
                'amount' => 'required|integer'
            ]
        );

        if ($validator->fails()) {
            return response()->json(
                ["Hiba!" => "Legalább egy elemet kihagytál!"],
                401
            );
        }

        Ingredient_Recipe::create($request->all());

        return response()->json(
            ["Sikeres feltöltés"],
            201
        );
    }


    public function update(Request $request, $ingredientId, $recipeId)
    {        
        $validator = Validator::make(
            $request->all(),
            [
                'amount' => 'required|integer'
            ]
        );

        if (!Ingredients::where('id', $ingredientId)->exists()) {
        return response()->json(
            ['hiba' => 'Nem létező ingredient'],
            404
        );
        }

        if (!Recipe::where('id', $recipeId)->exists()) {
            return response()->json(
                ['hiba' => 'Nem létező recept'],
                404
            );
        }

        if ($validator->fails()) {
            return response()->json(
                ["Hiba!" => "A grammAmount hiányzik vagy nem szám!"],
                401
            );
        }

        $updated = DB::table('ingredient_recipe')
        ->where('ingredientId', $ingredientId)
        ->where('recipeId', $recipeId)
        ->update([
            'amount' => $request->amount
        ]);

        if ($updated === 0) {
            return response()->json(
                ['hiba' => 'A kapcsolat nem létezik'],
                404
            );
        }

        return response()->json(
            ["Siker!" => "Kapcsolat sikeresen frissítve!"],
            200
        );
    }


    public function destroy($ingredientId, $recipeId)
    {
        $deleted = DB::table('ingredient_recipe')
        ->where('ingredientId', $ingredientId)
        ->where('recipeId', $recipeId)
        ->delete();

        if ($deleted === 0) {
        return response()->json(
            ['hiba' => 'Nincs ilyen kapcsolat az adatbázisban'],
            404
        );
        }

        return response()->json(
            ["Siker!" => "Kapcsolat sikeresen törölve!"],
            200
        );
    }


    public function getByRecipe($recipeId)
    {
        $ingredients = DB::table('ingredient_recipe as ir')
            ->join('ingredients as i', 'ir.ingredientId', '=', 'i.id')
            ->where('ir.recipeId', $recipeId)
            ->select(
                'i.id as ingredientId',
                'i.name as ingredientName',
                'ir.amount'
            )
            ->get();

        if ($ingredients->isEmpty()) {
            return response()->json(
                ["Hiba!" => "Ehhez a recepthez nincs hozzávaló!"],
                404
            );
        }

        return response()->json($ingredients, 200);
    }
}
