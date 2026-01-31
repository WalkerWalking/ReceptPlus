<?php

namespace App\Http\Controllers;

use App\Models\Ingredient_Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class IngredientRecipeController extends Controller
{
    /**
     * Összes recept + hozzávaló + grammAmount
     */
    public function index()
    {
        // Összetett lekérés: recept + hozzávalók + grammAmount
        $recipes = DB::table('ingredient_recipe as ir')
            ->join('recipes as r', 'ir.recipeId', '=', 'r.id')
            ->join('ingredients as i', 'ir.ingredientId', '=', 'i.id')
            ->select(
                'r.id as recipeId',
                'r.name as recipeName',
                'i.id as ingredientId',
                'i.name as ingredientName',
                'ir.gramAmount'
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

    /**
     * Új hozzávaló-recept kapcsolat létrehozása
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'recipeId' => 'required',
                'ingredientId' => 'required',
                'gramAmount' => 'required|integer'
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

    /**
     * Pivot tábla rekord frissítése (grammAmount)
     */
    public function update(Request $request, $ingredientId, $recipeId)
    {
        $record = Ingredient_Recipe::where('ingredientId', $ingredientId)
            ->where('recipeId', $recipeId)
            ->first();

        if (!$record) {
            return response()->json(
                ["Hiba!" => "Nincs ilyen kapcsolat az adatbázisban!"],
                404
            );
        }

        $validator = Validator::make(
            $request->all(),
            [
                'gramAmount' => 'required|integer'
            ]
        );

        if ($validator->fails()) {
            return response()->json(
                ["Hiba!" => "A grammAmount hiányzik vagy nem szám!"],
                401
            );
        }

        $record->update($request->all());

        return response()->json(
            ["Siker!" => "Kapcsolat sikeresen frissítve!"],
            200
        );
    }

    /**
     * Pivot tábla rekord törlése
     */
    public function destroy($ingredientId, $recipeId)
    {
        $record = Ingredient_Recipe::where('ingredientId', $ingredientId)
            ->where('recipeId', $recipeId)
            ->first();

        if (!$record) {
            return response()->json(
                ["Hiba!" => "Nincs ilyen kapcsolat az adatbázisban!"],
                404
            );
        }

        $record->delete();

        return response()->json(
            ["Siker!" => "Kapcsolat sikeresen törölve!"],
            200
        );
    }

    /**
     * Lekérés recept alapján
     */
    public function getByRecipe($recipeId)
    {
        $ingredients = DB::table('ingredient_recipe as ir')
            ->join('ingredients as i', 'ir.ingredientId', '=', 'i.id')
            ->where('ir.recipeId', $recipeId)
            ->select(
                'i.id as ingredientId',
                'i.name as ingredientName',
                'ir.gramAmount'
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
