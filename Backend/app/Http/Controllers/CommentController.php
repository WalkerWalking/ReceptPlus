<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    /**
     * Összes komment
     */
    public function index()
    {
        return Comment::all();
    }

    /**
     * Új komment létrehozása
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'content' => 'required',
                'recipeId' => 'required',
                'userId' => 'required'
            ]
        );

        if ($validator->fails()) {
            return response()->json(
                ["Hiba!" => "Legalább egy elemet kihagytál!"],
                401
            );
        }

        Comment::create($request->all());

        return response()->json(
            ["Sikeres feltöltés"],
            201
        );
    }

    /**
     * Komment frissítése
     */
    public function update(Request $request, $commentId)
    {
        $comment = Comment::find($commentId);

        if (!$comment) {
            return response()->json(
                ["Hiba!" => "Nincs ilyen komment az adatbázisban!"],
                404
            );
        }

        $validator = Validator::make(
            $request->all(),
            [
                'content' => 'required',
                'recipeId' => 'required',
                'userId' => 'required'
            ]
        );

        if ($validator->fails()) {
            return response()->json(
                ["Hiba!" => "Legalább egy elemet kihagytál!"],
                401
            );
        }

        $comment->update($request->all());

        return response()->json(
            ["Siker!" => "Komment sikeresen frissítve!"],
            200
        );
    }

    /**
     * Komment törlése
     */
    public function destroy($commentId)
    {
        $comment = Comment::find($commentId);

        if (!$comment) {
            return response()->json(
                ["Hiba!" => "Nincs ilyen komment az adatbázisban!"],
                404
            );
        }

        $comment->delete();

        return response()->json(
            ["Siker!" => "Komment sikeresen törölve!"],
            200
        );
    }

    /**
     * Komment lekérése ID alapján
     */
    public function getById($commentId)
    {
        $searched = Comment::where('id', '=', $commentId)->first();

        if (is_null($searched)) {
            return response()->json(
                ["Hiba!" => "Nincs ilyen komment ezzel az Id-val!"],
                404
            );
        }

        return response()->json($searched, 200);
    }

    /**
     * Egy recepthez tartozó kommentek
     */
    public function getByRecipeId($recipeId)
    {
        $comments = Comment::where('recipeId', '=', $recipeId)->get();

        if ($comments->isEmpty()) {
            return response()->json(
                ["Hiba!" => "Ehhez a recepthez nincs komment!"],
                404
            );
        }

        return response()->json($comments, 200);
    }

    /**
     * Egy user kommentjei
     */
    public function getByUserId($userId)
    {
        $comments = Comment::where('userId', '=', $userId)->get();

        if ($comments->isEmpty()) {
            return response()->json(
                ["Hiba!" => "Ez a felhasználó még nem kommentelt!"],
                404
            );
        }

        return response()->json($comments, 200);
    }
}
