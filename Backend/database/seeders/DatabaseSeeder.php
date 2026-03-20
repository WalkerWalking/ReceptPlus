<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Ingredients;
use App\Models\Recipe;
use App\Models\users;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {

        $users = [
            [
                'passwrd' => '12345678',
                'email' => 'pjozs@pelda.com',
                'name' => 'Példa József',
                'username' => 'pjzsf_1',
                'bodyweightKg' => 62,
                'heightCm' => 168,
                'birthDate' => '1993-05-12',
                'profilePictureURL' => '',
            ],
            [
                'passwrd' => '87654321',
                'email' => 'panna@pelda.com',
                'name' => 'Példa Anna',
                'username' => 'annapel',
                'bodyweightKg' => 82,
                'heightCm' => 182,
                'birthDate' => '1988-12-01',
                'profilePictureURL' => '',
            ],
        ];

        foreach ($users as $user) {
            users::create($user);
        }

        $ingredients = [
            ['id' => 1, 'name' => 'Alma', 'isFruit' => true, 'kcalPerGram' => 0.52, 'unit' => 'g'],
            ['id' => 2, 'name' => 'Banán', 'isFruit' => true, 'kcalPerGram' => 0.89, 'unit' => 'db'],
            ['id' => 3, 'name' => 'Csirkemell', 'isFruit' => false, 'kcalPerGram' => 1.65, 'unit' => 'g'],
            ['id' => 4, 'name' => 'Rizs', 'isFruit' => false, 'kcalPerGram' => 3.60, 'unit' => 'g'],
            ['id' => 5, 'name' => 'Paradicsom', 'isFruit' => false, 'kcalPerGram' => 20, 'unit' => 'db'],
            ['id' => 6,  'name' => 'Tojás', 'isFruit' => false, 'kcalPerGram' => 70,  'unit' => 'db'],
            ['id' => 7, 'name' => 'Liszt', 'isFruit' => false, 'kcalPerGram' => 3.64, 'unit' => 'g'],
            ['id' => 8, 'name' => 'Cukor', 'isFruit' => false, 'kcalPerGram' => 3.87, 'unit' => 'g'],
            ['id' => 9,  'name' => 'Narancs',     'isFruit' => true,  'kcalPerGram' => 62,  'unit' => 'db'],
            ['id' => 10, 'name' => 'Eper', 'isFruit' => true, 'kcalPerGram' => 0.32, 'unit' => 'db'],
            ['id' => 11, 'name' => 'Körte',       'isFruit' => true,  'kcalPerGram' => 57,  'unit' => 'db'],
            ['id' => 12, 'name' => 'Brokkoli', 'isFruit' => false, 'kcalPerGram' => 0.34, 'unit' => 'g'],
            ['id' => 13, 'name' => 'Sárgarépa', 'isFruit' => false, 'kcalPerGram' => 0.41, 'unit' => 'g'],
            ['id' => 14, 'name' => 'Vöröshagyma', 'isFruit' => false, 'kcalPerGram' => 44,  'unit' => 'db'],
            ['id' => 15, 'name' => 'Fokhagyma', 'isFruit' => false, 'kcalPerGram' => 1.49, 'unit' => 'db'],
            ['id' => 16, 'name' => 'Tej', 'isFruit' => false, 'kcalPerGram' => 0.42, 'unit' => 'ml'],
            ['id' => 17, 'name' => 'Tejföl', 'isFruit' => false, 'kcalPerGram' => 1.93, 'unit' => 'g'],
            ['id' => 18, 'name' => 'Sajt', 'isFruit' => false, 'kcalPerGram' => 4.02, 'unit' => 'g'],
            ['id' => 19, 'name' => 'Marhahús', 'isFruit' => false, 'kcalPerGram' => 2.50, 'unit' => 'g'],
            ['id' => 20, 'name' => 'Lazac', 'isFruit' => false, 'kcalPerGram' => 2.08, 'unit' => 'g'],
            ['id' => 21, 'name' => 'Tonhal', 'isFruit' => false, 'kcalPerGram' => 1.32, 'unit' => 'g'],
            ['id' => 22, 'name' => 'Zabpehely', 'isFruit' => false, 'kcalPerGram' => 3.89, 'unit' => 'g'],
            ['id' => 23, 'name' => 'Méz', 'isFruit' => false, 'kcalPerGram' => 3.04, 'unit' => 'g'],
            ['id' => 24, 'name' => 'Olívaolaj', 'isFruit' => false, 'kcalPerGram' => 8.84, 'unit' => 'ml'],
            ['id' => 25, 'name' => 'Paprika', 'isFruit' => false, 'kcalPerGram' => 0.31, 'unit' => 'g'],
            ['id' => 26, 'name' => 'Uborka', 'isFruit' => false, 'kcalPerGram' => 0.16, 'unit' => 'db'],
            ['id' => 27, 'name' => 'Gomba', 'isFruit' => false, 'kcalPerGram' => 0.22, 'unit' => 'g'],
            ['id' => 28, 'name' => 'Krumpli', 'isFruit' => false, 'kcalPerGram' => 150, 'unit' => 'db'],
            ['id' => 29, 'name' => 'Tejsavó fehérje', 'isFruit' => false, 'kcalPerGram' => 4.12, 'unit' => 'g'],
            ['id' => 30, 'name' => 'Mandula', 'isFruit' => false, 'kcalPerGram' => 5.76, 'unit' => 'g'],
            ['id' => 31, 'name' => 'Joghurt natúr', 'isFruit' => false, 'kcalPerGram' => 0.59, 'unit' => 'g'],
            ['id' => 32, 'name' => 'Görög joghurt', 'isFruit' => false, 'kcalPerGram' => 0.97, 'unit' => 'g'],
            ['id' => 33, 'name' => 'Vaj', 'isFruit' => false, 'kcalPerGram' => 7.17, 'unit' => 'g'],
            ['id' => 34, 'name' => 'Margarin', 'isFruit' => false, 'kcalPerGram' => 7.20, 'unit' => 'g'],
            ['id' => 35, 'name' => 'Teljes kiőrlésű kenyér', 'isFruit' => false, 'kcalPerGram' => 2.47, 'unit' => 'g'],
            ['id' => 36, 'name' => 'Fehér kenyér', 'isFruit' => false, 'kcalPerGram' => 2.65, 'unit' => 'g'],
            ['id' => 37, 'name' => 'Sonka', 'isFruit' => false, 'kcalPerGram' => 1.45, 'unit' => 'g'],
            ['id' => 38, 'name' => 'Pulykamell', 'isFruit' => false, 'kcalPerGram' => 1.35, 'unit' => 'g'],
            ['id' => 39, 'name' => 'Bacon', 'isFruit' => false, 'kcalPerGram' => 5.41, 'unit' => 'g'],
            ['id' => 40, 'name' => 'Kolbász', 'isFruit' => false, 'kcalPerGram' => 4.55, 'unit' => 'g'],
            ['id' => 41, 'name' => 'Túró', 'isFruit' => false, 'kcalPerGram' => 0.98, 'unit' => 'g'],
            ['id' => 42, 'name' => 'Tejszín', 'isFruit' => false, 'kcalPerGram' => 3.40, 'unit' => 'ml'],
            ['id' => 43, 'name' => 'Kakaópor', 'isFruit' => false, 'kcalPerGram' => 2.28, 'unit' => 'g'],
            ['id' => 44, 'name' => 'Csokoládé ét', 'isFruit' => false, 'kcalPerGram' => 5.46, 'unit' => 'g'],
            ['id' => 45, 'name' => 'Csokoládé tej', 'isFruit' => false, 'kcalPerGram' => 5.35, 'unit' => 'g'],
            ['id' => 46, 'name' => 'Citrom',  'isFruit' => true, 'kcalPerGram' => 17,  'unit' => 'db'],
            ['id' => 47, 'name' => 'Lime',    'isFruit' => true, 'kcalPerGram' => 20,  'unit' => 'db'],
            ['id' => 48, 'name' => 'Avokádó', 'isFruit' => true, 'kcalPerGram' => 240, 'unit' => 'db'],
            ['id' => 49, 'name' => 'Kókuszolaj', 'isFruit' => false, 'kcalPerGram' => 8.62, 'unit' => 'g'],
            ['id' => 50, 'name' => 'Kókuszreszelék', 'isFruit' => false, 'kcalPerGram' => 6.60, 'unit' => 'g'],
            ['id' => 51, 'name' => 'Mogyoróvaj', 'isFruit' => false, 'kcalPerGram' => 5.88, 'unit' => 'g'],
            ['id' => 52, 'name' => 'Dió', 'isFruit' => false, 'kcalPerGram' => 6.54, 'unit' => 'g'],
            ['id' => 53, 'name' => 'Kesudió', 'isFruit' => false, 'kcalPerGram' => 5.53, 'unit' => 'g'],
            ['id' => 54, 'name' => 'Lencse', 'isFruit' => false, 'kcalPerGram' => 3.53, 'unit' => 'g'],
            ['id' => 55, 'name' => 'Csicseriborsó', 'isFruit' => false, 'kcalPerGram' => 3.64, 'unit' => 'g'],
            ['id' => 56, 'name' => 'Vörös bab', 'isFruit' => false, 'kcalPerGram' => 3.37, 'unit' => 'g'],
            ['id' => 57, 'name' => 'Borsó', 'isFruit' => false, 'kcalPerGram' => 0.81, 'unit' => 'g'],
            ['id' => 58, 'name' => 'Spenót', 'isFruit' => false, 'kcalPerGram' => 0.23, 'unit' => 'g'],
            ['id' => 59, 'name' => 'Saláta', 'isFruit' => false, 'kcalPerGram' => 0.15, 'unit' => 'g'],
            ['id' => 60, 'name' => 'Cukkini', 'isFruit' => false, 'kcalPerGram' => 0.17, 'unit' => 'g'],
            ['id' => 61, 'name' => 'Padlizsán', 'isFruit' => false, 'kcalPerGram' => 0.25, 'unit' => 'g'],
            ['id' => 62, 'name' => 'Kukorica', 'isFruit' => false, 'kcalPerGram' => 0.86, 'unit' => 'g'],
            ['id' => 63, 'name' => 'Ketchup', 'isFruit' => false, 'kcalPerGram' => 1.12, 'unit' => 'g'],
            ['id' => 64, 'name' => 'Majonéz', 'isFruit' => false, 'kcalPerGram' => 6.80, 'unit' => 'g'],
            ['id' => 65, 'name' => 'Mustár', 'isFruit' => false, 'kcalPerGram' => 0.66, 'unit' => 'g'],
            ['id' => 66, 'name' => 'Szójaszósz', 'isFruit' => false, 'kcalPerGram' => 0.53, 'unit' => 'ml'],
            ['id' => 67, 'name' => 'Tészta (száraz)', 'isFruit' => false, 'kcalPerGram' => 3.71, 'unit' => 'g'],
            ['id' => 68, 'name' => 'Bulgur', 'isFruit' => false, 'kcalPerGram' => 3.42, 'unit' => 'g'],
            ['id' => 69, 'name' => 'Quinoa', 'isFruit' => false, 'kcalPerGram' => 3.68, 'unit' => 'g'],
            ['id' => 70, 'name' => 'Tofu', 'isFruit' => false, 'kcalPerGram' => 0.76, 'unit' => 'g'],
            ['id' => 71, 'name' => 'Áfonya', 'isFruit' => true, 'kcalPerGram' => 0.57, 'unit' => 'g'],
            ['id' => 72, 'name' => 'Málna', 'isFruit' => true, 'kcalPerGram' => 0.52, 'unit' => 'g'],
            ['id' => 73, 'name' => 'Szeder', 'isFruit' => true, 'kcalPerGram' => 0.43, 'unit' => 'g'],
            ['id' => 74, 'name' => 'Ananász', 'isFruit' => true, 'kcalPerGram' => 0.50, 'unit' => 'g'],
            ['id' => 75, 'name' => 'Mangó', 'isFruit' => true, 'kcalPerGram' => 0.60, 'unit' => 'g'],
            ['id' => 76, 'name' => 'Szőlő', 'isFruit' => true, 'kcalPerGram' => 0.69, 'unit' => 'g'],
            ['id' => 77, 'name' => 'Datolya', 'isFruit' => true, 'kcalPerGram' => 2.82, 'unit' => 'g'],
            ['id' => 78, 'name' => 'Mazsola', 'isFruit' => true, 'kcalPerGram' => 2.99, 'unit' => 'g'],
            ['id' => 79, 'name' => 'Füge', 'isFruit' => true, 'kcalPerGram' => 0.74, 'unit' => 'g'],
            ['id' => 80, 'name' => 'Kivi', 'isFruit' => true, 'kcalPerGram' => 42, 'unit' => 'db'],
            ['id' => 81, 'name' => 'Zöldbab', 'isFruit' => false, 'kcalPerGram' => 0.31, 'unit' => 'g'],
            ['id' => 82, 'name' => 'Karfiol', 'isFruit' => false, 'kcalPerGram' => 0.25, 'unit' => 'g'],
            ['id' => 83, 'name' => 'Kelbimbó', 'isFruit' => false, 'kcalPerGram' => 0.43, 'unit' => 'g'],
            ['id' => 84, 'name' => 'Vöröskáposzta', 'isFruit' => false, 'kcalPerGram' => 0.31, 'unit' => 'g'],
            ['id' => 85, 'name' => 'Fejes káposzta', 'isFruit' => false, 'kcalPerGram' => 0.25, 'unit' => 'g'],
            ['id' => 86, 'name' => 'Cékla', 'isFruit' => false, 'kcalPerGram' => 0.43, 'unit' => 'g'],
            ['id' => 87, 'name' => 'Édesburgonya', 'isFruit' => false, 'kcalPerGram' => 0.86, 'unit' => 'g'],
            ['id' => 88, 'name' => 'Hajdina', 'isFruit' => false, 'kcalPerGram' => 3.43, 'unit' => 'g'],
            ['id' => 89, 'name' => 'Kuszkusz', 'isFruit' => false, 'kcalPerGram' => 3.76, 'unit' => 'g'],
            ['id' => 90, 'name' => 'Rizstej', 'isFruit' => false, 'kcalPerGram' => 0.47, 'unit' => 'ml'],
            ['id' => 91, 'name' => 'Mandulatej', 'isFruit' => false, 'kcalPerGram' => 0.13, 'unit' => 'ml'],
            ['id' => 92, 'name' => 'Zabtej', 'isFruit' => false, 'kcalPerGram' => 0.46, 'unit' => 'ml'],
            ['id' => 93, 'name' => 'Kecskesajt', 'isFruit' => false, 'kcalPerGram' => 3.64, 'unit' => 'g'],
            ['id' => 94, 'name' => 'Feta sajt', 'isFruit' => false, 'kcalPerGram' => 2.64, 'unit' => 'g'],
            ['id' => 95, 'name' => 'Mozzarella', 'isFruit' => false, 'kcalPerGram' => 2.80, 'unit' => 'g'],
            ['id' => 96, 'name' => 'Ricotta', 'isFruit' => false, 'kcalPerGram' => 1.74, 'unit' => 'g'],
            ['id' => 97, 'name' => 'Pesto', 'isFruit' => false, 'kcalPerGram' => 4.54, 'unit' => 'g'],
            ['id' => 98, 'name' => 'Szezámmag', 'isFruit' => false, 'kcalPerGram' => 5.73, 'unit' => 'g'],
            ['id' => 99, 'name' => 'Chia mag', 'isFruit' => false, 'kcalPerGram' => 4.86, 'unit' => 'g'],
            ['id' => 100, 'name' => 'Lenmag', 'isFruit' => false, 'kcalPerGram' => 5.34, 'unit' => 'g'],
        ];

        foreach ($ingredients as $ingredient) {
            Ingredients::create($ingredient);
        }

        $recipes = [
            [
                'id' => 1,
                'name' => 'Csirkemell rizzsel',
                'userId' => 1,
                'imageUrl' => 'http://127.0.0.1:8000/storage/recipeImages/csirkemell_rizzsel.jpg',
                'description' => 'A rizst főzd meg enyhén sós vízben. A csirkemellet vágd szeletekre, fűszerezd ízlés szerint, majd serpenyőben süsd aranybarnára. A paradicsomot szeleteld fel, és tálald a csirkével és a rizzsel együtt.',
            ],
            [
                'id' => 2,
                'name' => 'Banános turmix',
                'userId' => 1,
                'imageUrl' => 'http://127.0.0.1:8000/storage/recipeImages/banan_turmix.jpg',
                'description' => 'A banánt tedd turmixgépbe, add hozzá a tojást, majd turmixold simára. Fogyaszthatod azonnal, hidegen a legfinomabb.',
            ],
            [
                'id' => 3,
                'name' => 'Paradicsomos omlett',
                'userId' => 1,
                'imageUrl' => 'http://127.0.0.1:8000/storage/recipeImages/omlett.jpg',
                'description' => 'A tojásokat verd fel egy tálban. A paradicsomot vágd kisebb darabokra. Serpenyőben süsd meg az omlettet, majd a paradicsomot tedd rá a tetejére, és hajtsd félbe.',
            ],
            [
                'id' => 4,
                'name' => 'Protein shake B-version',
                'userId' => 2,
                'imageUrl' => 'http://127.0.0.1:8000/storage/recipeImages/choc-pb-carm-protein-shake.jpg',
                'description' => 'A banánt, a cukrot és a tojást tedd turmixgépbe, majd turmixold krémes állagúra. Fogyaszd frissen, akár edzés után is.',
            ],
            [
                'id' => 5,
                'name' => 'Zabkásás fehérje reggeli',
                'userId' => 1,
                'imageUrl' => 'http://127.0.0.1:8000/storage/recipeImages/zabkasa.jpg',
                'description' => 'A zabpelyhet főzd össze a tejjel pár perc alatt. Keverd hozzá a tejsavó fehérjét és a mézet, majd jól dolgozd el. Melegen tálald.',
            ],
            [
                'id' => 6,
                'name' => 'Lazacos zöldséges tál',
                'userId' => 2,
                'imageUrl' => 'http://127.0.0.1:8000/storage/recipeImages/lazacostal.jpg',
                'description' => 'A lazacot fűszerezd, majd serpenyőben vagy sütőben süsd készre. A brokkolit párold meg, a paprikát szeleteld fel. Tálald a lazacot a zöldségekkel, és locsold meg egy kevés olívaolajjal.',
            ],
            [
                'id' => 7,
                'name' => 'Marhahúsos ragu krumplival',
                'userId' => 1,
                'imageUrl' => 'http://127.0.0.1:8000/storage/recipeImages/ragu.jpg',
                'description' => 'A marhahúst kockázd fel, majd pirítsd meg. Add hozzá az apróra vágott vöröshagymát és fokhagymát, majd kevés vízzel párold puhára. A krumplit főzd vagy süsd meg külön, és a ragu mellé tálald.',
            ],
            [
                'id' => 8,
                'name' => 'Gyümölcsös joghurtos smoothie',
                'userId' => 2,
                'imageUrl' => 'http://127.0.0.1:8000/storage/recipeImages/smoothie.jpg',
                'description' => 'A narancsot és a körtét tisztítsd meg, majd darabold fel. Az eperrel és a tejjel együtt tedd turmixgépbe, majd turmixold simára. Hidegen tálald.',
            ],
        ];

        foreach ($recipes as $recipe) {
            Recipe::create($recipe);
        }

        $comments = [
            ['id' => 1, 'content' => 'Nagyon finom lett, köszi!', 'recipeId' => 1, 'userId' => 2],
            ['id' => 2, 'content' => 'Ez a turmix brutál jó lett!', 'recipeId' => 2, 'userId' => 2],
            ['id' => 3, 'content' => 'Remek reggeli ötlet, köszönöm!', 'recipeId' => 3, 'userId' => 2],
            ['id' => 4, 'content' => 'Ez a protein shake nagyon jól sikerült!', 'recipeId' => 4, 'userId' => 1],
        ];

        foreach ($comments as $comment) {
            Comment::create($comment);
        }

        $userIngredients = [
            ['userId' => 1, 'ingredientId' => 1, 'amount' => 500],
            ['userId' => 1, 'ingredientId' => 3, 'amount' => 800],
            ['userId' => 1, 'ingredientId' => 4, 'amount' => 1000],
            ['userId' => 1, 'ingredientId' => 6, 'amount' => 3],
            ['userId' => 1, 'ingredientId' => 5, 'amount' => 5],
            ['userId' => 2, 'ingredientId' => 2, 'amount' => 300],
            ['userId' => 2, 'ingredientId' => 5, 'amount' => 5],
            ['userId' => 2, 'ingredientId' => 7, 'amount' => 1000],
            ['userId' => 2, 'ingredientId' => 8, 'amount' => 500],
        ];

        DB::table('user_ingredient')->insert($userIngredients);

        $ingredientRecipes = [
            ['ingredientId' => 3, 'recipeId' => 1, 'amount' => 300],
            ['ingredientId' => 4, 'recipeId' => 1, 'amount' => 200],
            ['ingredientId' => 5, 'recipeId' => 1, 'amount' => 2],

            ['ingredientId' => 2, 'recipeId' => 2, 'amount' => 1],
            ['ingredientId' => 6, 'recipeId' => 2, 'amount' => 1],

            ['ingredientId' => 6, 'recipeId' => 3, 'amount' => 2],
            ['ingredientId' => 5, 'recipeId' => 3, 'amount' => 1],

            ['ingredientId' => 2, 'recipeId' => 4, 'amount' => 1],
            ['ingredientId' => 8, 'recipeId' => 4, 'amount' => 30],
            ['ingredientId' => 6, 'recipeId' => 4, 'amount' => 2],

            ['ingredientId' => 22, 'recipeId' => 5, 'amount' => 80],
            ['ingredientId' => 16, 'recipeId' => 5, 'amount' => 200],
            ['ingredientId' => 29, 'recipeId' => 5, 'amount' => 30],
            ['ingredientId' => 23, 'recipeId' => 5, 'amount' => 20],

            ['ingredientId' => 20, 'recipeId' => 6, 'amount' => 180],
            ['ingredientId' => 12, 'recipeId' => 6, 'amount' => 1],
            ['ingredientId' => 25, 'recipeId' => 6, 'amount' => 1],
            ['ingredientId' => 24, 'recipeId' => 6, 'amount' => 10],

            ['ingredientId' => 19, 'recipeId' => 7, 'amount' => 250],
            ['ingredientId' => 28, 'recipeId' => 7, 'amount' => 3],
            ['ingredientId' => 14, 'recipeId' => 7, 'amount' => 1],
            ['ingredientId' => 15, 'recipeId' => 7, 'amount' => 2],

            ['ingredientId' => 9, 'recipeId' => 8, 'amount' => 1],
            ['ingredientId' => 10, 'recipeId' => 8, 'amount' => 5],
            ['ingredientId' => 11, 'recipeId' => 8, 'amount' => 1],
            ['ingredientId' => 16, 'recipeId' => 8, 'amount' => 200],
        ];

        DB::table('ingredient_recipe')->insert($ingredientRecipes);

        $recipes = Recipe::all();

        foreach ($recipes as $recipe) {

            $ingredients = DB::table('ingredient_recipe')
                ->join('ingredients', 'ingredient_recipe.ingredientId', '=', 'ingredients.id')
                ->where('ingredient_recipe.recipeId', $recipe->id)
                ->select(
                    'ingredient_recipe.amount',
                    'ingredients.kcalPerGram'
                )
                ->get();

            $totalCalories = 0;

            foreach ($ingredients as $ingredient) {
                $totalCalories += $ingredient->amount * $ingredient->kcalPerGram;
            }

            $recipe->calories = round($totalCalories);
            $recipe->save();

        }
    }
}
