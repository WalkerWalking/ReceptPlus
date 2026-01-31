<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class RecipeController extends Controller
{
    /**
     * Bejelentkezett user receptjei
     */
    public function index()
    {
        return Recipe::all();
    }


    /**
     * Recept létrehozása
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'userId' => 'required',
                'imageUrl' => 'nullable'
            ]
        );

        if ($validator->fails()) {
            return response()->json(
                ["Hiba!" => "Legalább egy elemet kihagytál!"],
                401
            );
        }

        Recipe::create($request->all());

        return response()->json(
            ["Sikeres feltöltés"],
            201
        );
    }
    /**
     * Recept frissítése
     */
    public function update(Request $request, $id)
    {
        $recipe = Recipe::where("id", "=", $id)->first();

        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'imageUrl' => 'nullable|string',
        ]);

        $recipe->update($request->all());

        return response()->json($recipe);
    }

    /**
     * Recept törlése
     */
    public function destroy($recipeId)
    {
        $recipe = Recipe::find($recipeId);

        if (!$recipe) {
            return response()->json([
                "Hiba!" => "Nincs ilyen recept az adatbázisban!"
            ], 404);
        }

        $recipe->delete();

        return response()->json([
            "Siker!" => "Ez a recept sikeresen törölve!"
        ], 200);
    }

    public function getbyId($recipeId)
    {
        $searched = Recipe::where('id', '=', $recipeId)->first();

        if (is_null($searched)) {
            return response()->json(
                ["Hiba!" => "Nincs ilyen recept ezzel az Id-val!"],
                404
            );
        }

        return response()->json($searched, 200);
    }
}
