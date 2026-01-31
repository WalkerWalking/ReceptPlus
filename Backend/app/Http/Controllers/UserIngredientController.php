<?php

namespace App\Http\Controllers;

use App\Models\User_Ingredient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserIngredientController extends Controller
{
    /**
     * Listázás: minden pivot rekord + kapcsolódó ingredient és user
     */
    public function index()
    {
        $userIngredients = User_Ingredient::with(['ingredient', 'user'])->get();
        return response()->json($userIngredients, 200);
    }

    /**
     * Egy konkrét rekord lekérése + kapcsolatokkal
     */
    public function getById($userId, $ingredientId)
    {
        $userIngredient = User_Ingredient::with(['ingredient', 'user'])
            ->where('userId', $userId)
            ->where('ingredientId', $ingredientId)
            ->first();

        if (!$userIngredient) {
            return response()->json([
                "Hiba!" => "Nincs ilyen rekord az adatbázisban!"
            ], 404);
        }

        return response()->json($userIngredient, 200);
    }

    /**
     * Új rekord létrehozása
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'userId' => 'required|exists:users,id',
            'ingredientId' => 'required|exists:ingredients,id',
            'gramAmount' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                "Hiba!" => "Legalább egy kötelező mezőt kihagytál!"
            ], 401);
        }

        $userIngredient = User_Ingredient::create($request->only(['userId', 'ingredientId', 'gramAmount']));

        // Betöltjük a kapcsolódó modelleket
        $userIngredient = $userIngredient->load(['ingredient', 'user']);

        return response()->json([
            "Sikeres feltöltés" => $userIngredient
        ], 201);
    }

    /**
     * Egy meglévő rekord frissítése
     */
    public function update(Request $request, $userId, $ingredientId)
    {
        $validator = Validator::make($request->all(), [
            'gramAmount' => 'required|integer|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json(
                ["Hiba!" => "A gramAmount mező kötelező és 0 vagy nagyobb szám kell legyen!"],
                422
            );
        }

        $updated = User_Ingredient::where('userId', $userId)
            ->where('ingredientId', $ingredientId)
            ->update(['gramAmount' => $request->gramAmount]);

        if (!$updated) {
            return response()->json(
                ["Hiba!" => "Nincs ilyen rekord az adatbázisban vagy az érték nem változott!"],
                404
            );
        }

        $userIngredient = User_Ingredient::where('userId', $userId)
            ->where('ingredientId', $ingredientId)
            ->first()
            ->load(['ingredient', 'user']);

        return response()->json(
            ["Siker!" => "Felhasználó összetevő frissítve!", "data" => $userIngredient],
            200
        );
    }

    /**
     * Egy rekord törlése
     */
    public function destroy($userId, $ingredientId)
    {
        $deleted = User_Ingredient::where('userId', $userId)
            ->where('ingredientId', $ingredientId)
            ->delete();

        if (!$deleted) {
            return response()->json(["Hiba!" => "Nincs ilyen rekord az adatbázisban!"], 404);
        }

        return response()->json(["Siker!" => "Felhasználó összetevő törölve!"], 200);
    }
}
