<?php

namespace App\Http\Controllers;

use App\Models\User_Ingredient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserIngredientController extends Controller
{
    public function index()
    {
        $userIngredients = User_Ingredient::with(['ingredient', 'user'])->get();

        return response()->json($userIngredients, 200);
    }

    public function getById($userId, $ingredientId)
    {
        $userIngredient = User_Ingredient::with(['ingredient', 'user'])
            ->where('userId', $userId)
            ->where('ingredientId', $ingredientId)
            ->first();

        if (! $userIngredient) {
            return response()->json([
                'Hiba!' => 'Nincs ilyen rekord az adatbázisban!',
            ], 404);
        }

        return response()->json($userIngredient, 200);
    }

    public function getUserIngredients($userId)
    {
        $userIngredients = User_Ingredient::with('ingredient')
            ->where('userId', $userId)
            ->get();

        return response()->json($userIngredients, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'userId' => 'required|exists:users,id',
            'ingredientId' => 'required|exists:ingredients,id',
            'amount' => 'required|numeric|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Hibás adatokat küldtél.',
            ], 422);
        }

        $existing = DB::table('user_ingredient')
            ->where('userId', $request->userId)
            ->where('ingredientId', $request->ingredientId)
            ->first();

        if ($existing) {
            DB::table('user_ingredient')
                ->where('userId', $request->userId)
                ->where('ingredientId', $request->ingredientId)
                ->update([
                    'amount' => $existing->amount + $request->amount,
                ]);

            return response()->json([
                'message' => 'A hozzávaló mennyisége sikeresen frissítve.',
            ], 200);
        }

        DB::table('user_ingredient')->insert([
            'userId' => $request->userId,
            'ingredientId' => $request->ingredientId,
            'amount' => $request->amount,
        ]);

        return response()->json([
            'message' => 'A hozzávaló sikeresen hozzáadva.',
        ], 201);
    }

 
    public function update(Request $request, $userId, $ingredientId)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(
                ['Hiba!' => 'A amount mező kötelező és 0 vagy nagyobb szám kell legyen!'],
                422
            );
        }

        $updated = User_Ingredient::where('userId', $userId)
            ->where('ingredientId', $ingredientId)
            ->update(['amount' => $request->amount]);

        if (! $updated) {
            return response()->json(
                ['Hiba!' => 'Nincs ilyen rekord az adatbázisban vagy az érték nem változott!'],
                404
            );
        }

        $userIngredient = User_Ingredient::where('userId', $userId)
            ->where('ingredientId', $ingredientId)
            ->first()
            ->load(['ingredient', 'user']);

        return response()->json(
            ['Siker!' => 'Felhasználó összetevő frissítve!', 'data' => $userIngredient],
            200
        );
    }

    public function destroy($userId, $ingredientId)
    {
        $deleted = User_Ingredient::where('userId', $userId)
            ->where('ingredientId', $ingredientId)
            ->delete();

        if (! $deleted) {
            return response()->json(['Hiba!' => 'Nincs ilyen rekord az adatbázisban!'], 404);
        }

        return response()->json(['Siker!' => 'Felhasználó összetevő törölve!'], 200);
    }
}
