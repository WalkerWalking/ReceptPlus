<?php

namespace App\Http\Controllers;

use App\Models\Ingredients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class IngredientsController extends Controller
{
    /**
     * Összes ingredient
     */
    public function index()
    {
        return Ingredients::all();
    }

    /**
     * Új ingredient létrehozása
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'isFruit' => 'required',
                'kcalPerGram' => 'required'
            ]
        );

        if ($validator->fails()) {
            return response()->json(
                ["Hiba!" => "Legalább egy elemet kihagytál!"],
                401
            );
        }

        Ingredients::create($request->all());

        return response()->json(
            ["Sikeres feltöltés"],
            201
        );
    }

    /**
     * Ingredient frissítése
     */
    public function update(Request $request, $ingredientId)
    {
        $ingredient = Ingredients::find($ingredientId);

        if (!$ingredient) {
            return response()->json(
                ["Hiba!" => "Nincs ilyen alapanyag az adatbázisban!"],
                404
            );
        }

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'isFruit' => 'required',
                'kcalPerGram' => 'required'
            ]
        );

        if ($validator->fails()) {
            return response()->json(
                ["Hiba!" => "Legalább egy elemet kihagytál!"],
                401
            );
        }

        $ingredient->update($request->all());

        return response()->json(
            ["Siker!" => "Alapanyag sikeresen frissítve!"],
            200
        );
    }

    /**
     * Ingredient törlése
     */
    public function destroy($ingredientId)
    {
        $ingredient = Ingredients::find($ingredientId);

        if (!$ingredient) {
            return response()->json(
                ["Hiba!" => "Nincs ilyen alapanyag az adatbázisban!"],
                404
            );
        }

        $ingredient->delete();

        return response()->json(
            ["Siker!" => "Alapanyag sikeresen törölve!"],
            200
        );
    }

    /**
     * Ingredient lekérése ID alapján
     */
    public function getById($ingredientId)
    {
        $searched = Ingredients::where('id', '=', $ingredientId)->first();

        if (is_null($searched)) {
            return response()->json(
                ["Hiba!" => "Nincs ilyen alapanyag ezzel az Id-val!"],
                404
            );
        }

        return response()->json($searched, 200);
    }

    /**
     * Csak gyümölcsök
     */
    public function getFruits()
    {
        $ingredients = Ingredients::where('isFruit', '=', true)->get();

        if ($ingredients->isEmpty()) {
            return response()->json(
                ["Hiba!" => "Nincs egyetlen gyümölcs sem!"],
                404
            );
        }

        return response()->json($ingredients, 200);
    }

    /**
     * Nem gyümölcs alapanyagok
     */
    public function getNonFruits()
    {
        $ingredients = Ingredients::where('isFruit', '=', false)->get();

        if ($ingredients->isEmpty()) {
            return response()->json(
                ["Hiba!" => "Nincs egyetlen nem gyümölcs alapanyag sem!"],
                404
            );
        }

        return response()->json($ingredients, 200);
    }

    /**
     * Kcal/gram nagyobb mint
     */
    public function MoreThan_kcalPerGram($value)
    {
        $ingredients = Ingredients::where('kcalPerGram', '>', $value)->get();

        if ($ingredients->isEmpty()) {
            return response()->json(
                ["Hiba!" => "Nincs ennél nagyobb kcal/gram érték!"],
                404
            );
        }

        return response()->json($ingredients, 200);
    }

    /**
     * Kcal/gram kisebb mint
     */
    public function LessThan_kcalPerGram($value)
    {
        $ingredients = Ingredients::where('kcalPerGram', '<', $value)->get();

        if ($ingredients->isEmpty()) {
            return response()->json(
                ["Hiba!" => "Nincs ennél kisebb kcal/gram érték!"],
                404
            );
        }

        return response()->json($ingredients, 200);
    }
}
