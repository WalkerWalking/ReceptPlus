<?php

namespace App\Http\Controllers;

use App\Models\users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{

    public function index()
    {
        return users::All();
    }

    public function store(Request $request)
    {
        $validator = Validator::Make(
            $request->all(),
            [
                'passwrd' => 'required',
                'email' => 'required',
                'name' => 'required',
                'username' => 'required'
            ]
        );

        if ($validator->fails()) {
            return response()->json(["Hiba!" => "Legalább egy elemet kihagytál!"], 401);
        }

        $user = users::Create($request->all());
        return response()->json(["Sikeres feltöltés"], 201);

    }

    public function update(Request $request, users $userId)
    {
        $validator = Validator::make($request->all(), [
            'passwrd' => 'required',
            'email' => 'required',
            'name' => 'required',
            'username' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(
                ["Hiba!" => "Legalább egy elemet kihagytál!"],
                401
            );
        }

        $userId->update($request->all());

        return response()->json(
            ["Siker!" => "Felhasználó sikeresen frissítve!"],
            200
        );
    }

    public function destroy($userId)
    {
        $user = users::find($userId);

        if (!$user) {
            return response()->json([
                "Hiba!" => "Nincs ilyen felhasználó az adatbázisban!"
            ], 404);
        }

        $user->delete();

        return response()->json([
            "Siker!" => "Ez a felhasználó sikeresen törölve!"
        ], 200);
    }

    public function getbyId($userId)
    {
        $searched = Users::where('id', '=', $userId)->first();

        if (is_null($searched)) {
            return response()->json(
                ["Hiba!" => "Nincs ilyen felhasználó ezzel az Id-val!"],
                404
            );
        }

        return response()->json($searched, 200);
    }

    public function MoreThan_bodyweightKg($value)
    {
        $searched = Users::where('bodyweightKg', '>', $value)->get();

        if ($searched->isEmpty()) {
            return response()->json(
                ["Hiba!" => "Nincs ennél az value-nál nagybobb bodyweightKg!"],
                404
            );
        }

        return response()->json($searched, 200);
    }

    public function LessThan_bodyweightKg($value)
    {
        $searched = Users::where('bodyweightKg', '<', $value)->get();

        if ($searched->isEmpty()) {
            return response()->json(
                ["Hiba!" => "Nincs ennél az value-nál kisebb bodyweightKg!"],
                404
            );
        }

        return response()->json($searched, 200);
    }

    public function hasFilter_profilePictureUrl()
    {
        $users = Users::whereNotNull('profilePictureUrl')->where('profilePictureUrl', '!=', '')->get();

        if ($users->isEmpty()) {
            return response()->json(
                ["Hiba!" => "Nincs egyetlen felhasználós sem profilképpel!"],
                404
            );
        }

        return response()->json($users, 200);

    }

}



/*
        $table->string('passwrd');
        $table->string('email')->unique();
        $table->string('name');
        $table->string('username')->unique();
        $table->integer('bodyweightKg')->nullable();
        $table->integer('heightCm')->nullable();
        $table->date('birthDate')->default(DB::raw('CURRENT_TIMESTAMP'))->nullable();
        $table->string('profilePictureUrl')->nullable();
*/
