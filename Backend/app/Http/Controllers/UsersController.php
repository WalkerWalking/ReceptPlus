<?php

namespace App\Http\Controllers;

use App\Models\users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    public function index()
    {
        return users::All();
    }

    public function checkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $exists = users::where('email', $request->email)->exists();

        return response()->json(['exists' => $exists]);
    }

    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = users::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'Nincs ilyen felhasználó!'], 404);
        }

        $token = Str::random(60);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => $token,
                'created_at' => now()
            ]
        );

        $resetLink = "http://localhost:4200/reset-password?token=" . $token . "&email=" . $request->email;

        // Email kiküldése
        Mail::send([], [], function ($message) use ($request, $resetLink) {
            $email = $request->email;

            $message->to($email)
                ->subject('Jelszó visszaállítása - Recept+')
                ->html("
<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
</head>
<body style='margin: 0; padding: 0; background-color: #f4f8eb; font-family: sans-serif;'>
    <table border='0' cellpadding='0' cellspacing='0' width='100%'>
        <tr>
            <td style='padding: 40px 0;'>
                <table align='center' border='0' cellpadding='0' cellspacing='0' width='500' style='background-color: #ffffff; border-radius: 24px; overflow: hidden; box-shadow: 0 20px 40px rgba(35, 91, 94, 0.1);'>
                    
                    <tr>
                        <td align='center' style='padding: 40px 40px 20px 40px;'>
                            <div style='font-size: 32px; font-weight: 800; color: #235B5E; letter-spacing: -1px;'>
                                Recept <span style='color: #FE7F2D;'>+</span>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td align='center' style='padding: 10px 40px 30px 40px;'>
                            <div style='background-color: #fff2e9; width: 80px; height: 80px; border-radius: 20px; line-height: 80px; font-size: 40px; text-align: center;'>
                                🔐
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td style='padding: 0 40px 40px 40px;'>
                            <table border='0' cellpadding='0' cellspacing='0' width='100%'>
                                <tr>
                                    <td align='center' style='color: #235B5E; font-size: 24px; font-weight: 700; padding-bottom: 20px;'>
                                        Jelszó visszaállítása
                                    </td>
                                </tr>
                                <tr>
                                    <td align='center' style='color: #5a6b6c; font-size: 16px; line-height: 1.6; padding-bottom: 35px;'>
                                        Szia! Biztonsági értesítést kaptunk, mert elfelejtett jelszó miatti helyreállítást kezdeményeztél a fiókodhoz.
                                    </td>
                                </tr>
                                <tr>
                                    <td align='center'>
                                        <a href='{$resetLink}' style='background-color: #FE7F2D; color: #ffffff; display: inline-block; font-size: 16px; font-weight: 700; line-height: 60px; text-align: center; text-decoration: none; width: 280px; border-radius: 18px;'>
                                            JELSZÓ MÓDOSÍTÁSA &rarr;
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td style='padding: 0 40px 40px 40px;'>
                            <div style='background-color: #f8faf5; border-radius: 16px; padding: 20px; border: 1px solid #e1e8d9;'>
                                <p style='color: #235B5E; font-size: 13px; line-height: 1.5; margin: 0;'>
                                    <strong>Biztonsági emlékeztető:</strong> Ha nem Te kérted ezt az e-mailt, fiókod továbbra is biztonságban van. Ebben az esetben semmilyen teendőd nincs.
                                </p>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td align='center' style='background-color: #235B5E; padding: 30px 40px;'>
                            <p style='color: #ffffff; font-size: 12px; opacity: 0.8; margin: 0 0 10px 0;'>
                                &copy; 2026 Recept+.
                            </p>
                            <p style='color: #ffffff; font-size: 11px; opacity: 0.5; margin: 0;'>
                                Címzett: {$email}
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
        ");
        });

        return response()->json(['message' => 'Email elküldve!']);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required',
            'passwrd' => 'required|min:6'
        ]);

        $resetData = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$resetData) {
            return response()->json(['message' => 'Érvénytelen token vagy e-mail!'], 400);
        }

        $user = users::where('email', $request->email)->first();
        if ($user) {
            $user->passwrd = $request->passwrd;
            $user->save();

            DB::table('password_reset_tokens')->where('email', $request->email)->delete();

            return response()->json(['message' => 'Jelszó sikeresen megváltoztatva!']);
        }

        return response()->json(['message' => 'Felhasználó nem található!'], 404);
    }

    public function store(Request $request)
    {
        $validator = Validator::Make(
            $request->all(),
            [
                'passwrd' => 'required',
                'email' => 'required',
                'name' => 'required',
                'username' => 'required',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['Hiba!' => 'Legalább egy elemet kihagytál!'], 401);
        }

        $user = users::Create($request->all());

        return response()->json(['Sikeres feltöltés'], 201);

    }

    public function update(Request $request, users $userId)
    {

        $validator = Validator::make($request->all(), [
            'passwrd' => 'required',
            'email' => 'required',
            'name' => 'required',
            'username' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(
                ['Hiba!' => 'Legalább egy elemet kihagytál!'],
                401
            );
        } else {
            if ($userId == null) {
                return response()->json(
                    ['Hiba!' => 'Nincs ilyen felhasználó az adatbázisban!'],
                    404
                );
            }
        }

        $userId->update($request->all());

        return response()->json(
            ['Siker!' => 'Felhasználó sikeresen frissítve!'],
            200
        );
    }

    public function destroy($userId)
    {
        $user = users::find($userId);

        if (!$user) {
            return response()->json([
                'Hiba!' => 'Nincs ilyen felhasználó az adatbázisban!',
            ], 404);
        }

        $user->delete();

        return response()->json([
            'Siker!' => 'Ez a felhasználó sikeresen törölve!',
        ], 200);
    }

    public function getbyEmail($email)
    {
        $searched = users::where('email', '=', $email)->first();

        if (is_null($searched)) {
            return response('Nincs ilyen felhasználó ezzel az email-címmel!', 404);
        }

        return response()->json($searched, 200);
    }

    public function MoreThan_bodyweightKg($value)
    {
        $searched = users::where('bodyweightKg', '>', $value)->get();

        if ($searched->isEmpty()) {
            return response()->json(
                ['Hiba!' => 'Nincs ennél az value-nál nagybobb bodyweightKg!'],
                404
            );
        }

        return response()->json($searched, 200);
    }

    public function LessThan_bodyweightKg($value)
    {
        $searched = users::where('bodyweightKg', '<', $value)->get();

        if ($searched->isEmpty()) {
            return response()->json(
                ['Hiba!' => 'Nincs ennél az value-nál kisebb bodyweightKg!'],
                404
            );
        }

        return response()->json($searched, 200);
    }

    public function hasFilter_profilePictureUrl()
    {
        $users = users::whereNotNull('profilePictureUrl')->where('profilePictureUrl', '!=', '')->get();

        if ($users->isEmpty()) {
            return response()->json(
                ['Hiba!' => 'Nincs egyetlen felhasználós sem profilképpel!'],
                404
            );
        }

        return response()->json($users, 200);

    }

    public function login(Request $request)
    {
        $user = users::where('email', '=', $request->email)->first();

        if ($user && $user->passwrd == $request->passwrd) {
            return response()->json($user, 200);
        }

        return response()->json(['Hiba!' => 'Hibás email vagy jelszó!'], 401);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'passwrd' => 'required',
            'email' => 'required|email|unique:users',
            'name' => 'required',
            'username' => 'required|unique:users',
        ]);

        if ($validator->fails()) {
            return response()->json(
                ['Hiba!' => 'Legalább egy elemet kihagytál!'],
                401
            );
        }

        $user = users::create($request->all());

        return response()->json($user, 201);
    }

    public function updateCalories(Request $request, $id)
    {
        $user = users::find($id);

        if (!$user) {
            return response()->json(['message' => 'Nincs ilyen felhasználó'], 404);
        }

        $user->caloriesEaten = $request->caloriesEaten;
        $user->save();

        return response()->json($user);
    }

    public function uploadProfileImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:2048',
            'userId' => 'required',
        ]);

        $user = users::find($request->userId);

        if (!$user) {
            return response()->json([
                'message' => 'Nincs ilyen felhasználó',
            ], 404);
        }

        $path = $request->file('image')->store('profilePictures', 'public');

        $url = asset('storage/' . $path);

        $user->profilePictureUrl = $url;
        $user->save();

        return response()->json([
            'message' => 'Profilkép frissítve',
            'url' => $url,
            'user' => $user,
        ]);
    }

    public function updateProfile(Request $request, $id)
    {
        $user = users::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'Nincs ilyen felhasználó',
            ], 404);
        }

        $user->birthDate = $request->birthDate;
        $user->bodyweightKg = $request->bodyweightKg;
        $user->heightCm = $request->heightCm;

        $user->save();

        return response()->json([
            'message' => 'Adatok frissítve',
            'user' => $user,
        ]);
    }
}