<?php

namespace Database\Seeders;

use App\Models\users;
use App\Models\Recipe;
use App\Models\User_Ingredient;
use App\Models\Ingredients;
use App\Models\INgredient_Recipe;
use App\Models\Comment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

//Alap adatok feltöltése
class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {

        // Felhasználók
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

        //Hozzávalók
        $ingredients = [
            ['id'=>1,'name'=>'Alma','isFruit'=>true,'kcalPerGram'=>0.52],
            ['id'=>2,'name'=>'Banán','isFruit'=>true,'kcalPerGram'=>0.89],
            ['id'=>3,'name'=>'Narancs','isFruit'=>true,'kcalPerGram'=>0.47],
            ['id'=>4,'name'=>'Mandarin','isFruit'=>true,'kcalPerGram'=>0.53],
            ['id'=>5,'name'=>'Citrom','isFruit'=>true,'kcalPerGram'=>0.29],
            ['id'=>6,'name'=>'Lime','isFruit'=>true,'kcalPerGram'=>0.30],
            ['id'=>7,'name'=>'Körte','isFruit'=>true,'kcalPerGram'=>0.57],
            ['id'=>8,'name'=>'Őszibarack','isFruit'=>true,'kcalPerGram'=>0.39],
            ['id'=>9,'name'=>'Sárgabarack','isFruit'=>true,'kcalPerGram'=>0.48],
            ['id'=>10,'name'=>'Szilva','isFruit'=>true,'kcalPerGram'=>0.46],
            ['id'=>11,'name'=>'Cseresznye','isFruit'=>true,'kcalPerGram'=>0.63],
            ['id'=>12,'name'=>'Meggy','isFruit'=>true,'kcalPerGram'=>0.50],
            ['id'=>13,'name'=>'Eper','isFruit'=>true,'kcalPerGram'=>0.32],
            ['id'=>14,'name'=>'Málna','isFruit'=>true,'kcalPerGram'=>0.52],
            ['id'=>15,'name'=>'Áfonya','isFruit'=>true,'kcalPerGram'=>0.57],
            ['id'=>16,'name'=>'Szeder','isFruit'=>true,'kcalPerGram'=>0.43],
            ['id'=>17,'name'=>'Ananász','isFruit'=>true,'kcalPerGram'=>0.50],
            ['id'=>18,'name'=>'Mangó','isFruit'=>true,'kcalPerGram'=>0.60],
            ['id'=>19,'name'=>'Papaya','isFruit'=>true,'kcalPerGram'=>0.43],
            ['id'=>20,'name'=>'Gránátalma','isFruit'=>true,'kcalPerGram'=>0.83],
            ['id'=>21,'name'=>'Kivi','isFruit'=>true,'kcalPerGram'=>0.61],
            ['id'=>22,'name'=>'Szőlő','isFruit'=>true,'kcalPerGram'=>0.69],
            ['id'=>23,'name'=>'Görögdinnye','isFruit'=>true,'kcalPerGram'=>0.30],
            ['id'=>24,'name'=>'Sárgadinnye','isFruit'=>true,'kcalPerGram'=>0.34],
            ['id'=>25,'name'=>'Füge','isFruit'=>true,'kcalPerGram'=>0.74],

            ['id'=>26,'name'=>'Paradicsom','isFruit'=>false,'kcalPerGram'=>0.18],
            ['id'=>27,'name'=>'Paprika','isFruit'=>false,'kcalPerGram'=>0.20],
            ['id'=>28,'name'=>'Uborka','isFruit'=>false,'kcalPerGram'=>0.15],
            ['id'=>29,'name'=>'Vöröshagyma','isFruit'=>false,'kcalPerGram'=>0.40],
            ['id'=>30,'name'=>'Fokhagyma','isFruit'=>false,'kcalPerGram'=>1.49],
            ['id'=>31,'name'=>'Sárgarépa','isFruit'=>false,'kcalPerGram'=>0.41],
            ['id'=>32,'name'=>'Petrezselyemgyökér','isFruit'=>false,'kcalPerGram'=>0.55],
            ['id'=>33,'name'=>'Zeller','isFruit'=>false,'kcalPerGram'=>0.16],
            ['id'=>34,'name'=>'Brokkoli','isFruit'=>false,'kcalPerGram'=>0.34],
            ['id'=>35,'name'=>'Karfiol','isFruit'=>false,'kcalPerGram'=>0.25],
            ['id'=>36,'name'=>'Cukkini','isFruit'=>false,'kcalPerGram'=>0.17],
            ['id'=>37,'name'=>'Padlizsán','isFruit'=>false,'kcalPerGram'=>0.25],
            ['id'=>38,'name'=>'Spenót','isFruit'=>false,'kcalPerGram'=>0.23],
            ['id'=>39,'name'=>'Fejes saláta','isFruit'=>false,'kcalPerGram'=>0.15],
            ['id'=>40,'name'=>'Rukkola','isFruit'=>false,'kcalPerGram'=>0.25],
            ['id'=>41,'name'=>'Cékla','isFruit'=>false,'kcalPerGram'=>0.43],
            ['id'=>42,'name'=>'Káposzta','isFruit'=>false,'kcalPerGram'=>0.25],
            ['id'=>43,'name'=>'Kelbimbó','isFruit'=>false,'kcalPerGram'=>0.43],
            ['id'=>44,'name'=>'Kelkáposzta','isFruit'=>false,'kcalPerGram'=>0.49],
            ['id'=>45,'name'=>'Zöldborsó','isFruit'=>false,'kcalPerGram'=>0.81],

            ['id'=>46,'name'=>'Csirkemell','isFruit'=>false,'kcalPerGram'=>1.65],
            ['id'=>47,'name'=>'Csirkecomb','isFruit'=>false,'kcalPerGram'=>2.15],
            ['id'=>48,'name'=>'Pulykamell','isFruit'=>false,'kcalPerGram'=>1.35],
            ['id'=>49,'name'=>'Marhahús','isFruit'=>false,'kcalPerGram'=>2.50],
            ['id'=>50,'name'=>'Sertéshús','isFruit'=>false,'kcalPerGram'=>2.42],
            ['id'=>51,'name'=>'Bárányhús','isFruit'=>false,'kcalPerGram'=>2.94],
            ['id'=>52,'name'=>'Lazac','isFruit'=>false,'kcalPerGram'=>2.08],
            ['id'=>53,'name'=>'Tonhal','isFruit'=>false,'kcalPerGram'=>1.44],
            ['id'=>54,'name'=>'Tőkehal','isFruit'=>false,'kcalPerGram'=>0.82],
            ['id'=>55,'name'=>'Makréla','isFruit'=>false,'kcalPerGram'=>2.05],
            ['id'=>56,'name'=>'Garnéla','isFruit'=>false,'kcalPerGram'=>0.99],
      
            ['id'=>57,'name'=>'Tej','isFruit'=>false,'kcalPerGram'=>0.42],
            ['id'=>58,'name'=>'Tejföl','isFruit'=>false,'kcalPerGram'=>2.06],
            ['id'=>59,'name'=>'Joghurt','isFruit'=>false,'kcalPerGram'=>0.59],
            ['id'=>60,'name'=>'Görög joghurt','isFruit'=>false,'kcalPerGram'=>0.97],
            ['id'=>61,'name'=>'Túró','isFruit'=>false,'kcalPerGram'=>0.98],
            ['id'=>62,'name'=>'Trappista sajt','isFruit'=>false,'kcalPerGram'=>3.56],
            ['id'=>63,'name'=>'Mozzarella','isFruit'=>false,'kcalPerGram'=>2.80],
            ['id'=>64,'name'=>'Parmezán','isFruit'=>false,'kcalPerGram'=>4.31],
            ['id'=>65,'name'=>'Vaj','isFruit'=>false,'kcalPerGram'=>7.17],
        
            ['id'=>66,'name'=>'Fehér rizs','isFruit'=>false,'kcalPerGram'=>3.60],
            ['id'=>67,'name'=>'Barna rizs','isFruit'=>false,'kcalPerGram'=>3.70],
            ['id'=>68,'name'=>'Bulgur','isFruit'=>false,'kcalPerGram'=>3.42],
            ['id'=>69,'name'=>'Kuszkusz','isFruit'=>false,'kcalPerGram'=>3.76],
            ['id'=>70,'name'=>'Quinoa','isFruit'=>false,'kcalPerGram'=>3.68],
            ['id'=>71,'name'=>'Zabpehely','isFruit'=>false,'kcalPerGram'=>3.89],
            ['id'=>72,'name'=>'Liszt','isFruit'=>false,'kcalPerGram'=>3.64],
            ['id'=>73,'name'=>'Durum tészta','isFruit'=>false,'kcalPerGram'=>3.53],
            ['id'=>74,'name'=>'Teljes kiőrlésű kenyér','isFruit'=>false,'kcalPerGram'=>2.47],
          
            ['id'=>75,'name'=>'Mandula','isFruit'=>false,'kcalPerGram'=>5.76],
            ['id'=>76,'name'=>'Dió','isFruit'=>false,'kcalPerGram'=>6.54],
            ['id'=>77,'name'=>'Mogyoró','isFruit'=>false,'kcalPerGram'=>5.67],
            ['id'=>78,'name'=>'Kesudió','isFruit'=>false,'kcalPerGram'=>5.53],
            ['id'=>79,'name'=>'Pisztácia','isFruit'=>false,'kcalPerGram'=>5.62],
            ['id'=>80,'name'=>'Napraforgómag','isFruit'=>false,'kcalPerGram'=>5.84],
            ['id'=>81,'name'=>'Tökmag','isFruit'=>false,'kcalPerGram'=>5.59],
            ['id'=>82,'name'=>'Lenmag','isFruit'=>false,'kcalPerGram'=>5.34],
            ['id'=>83,'name'=>'Olívaolaj','isFruit'=>false,'kcalPerGram'=>8.84],
            ['id'=>84,'name'=>'Napraforgóolaj','isFruit'=>false,'kcalPerGram'=>8.84],
            ['id'=>85,'name'=>'Kókuszolaj','isFruit'=>false,'kcalPerGram'=>8.92],
      
            ['id'=>86,'name'=>'Só','isFruit'=>false,'kcalPerGram'=>0.00],
            ['id'=>87,'name'=>'Fekete bors','isFruit'=>false,'kcalPerGram'=>2.51],
            ['id'=>88,'name'=>'Pirospaprika','isFruit'=>false,'kcalPerGram'=>2.82],
            ['id'=>89,'name'=>'Kömény','isFruit'=>false,'kcalPerGram'=>3.33],
            ['id'=>90,'name'=>'Bazsalikom','isFruit'=>false,'kcalPerGram'=>2.33],
            ['id'=>91,'name'=>'Oregánó','isFruit'=>false,'kcalPerGram'=>2.65],
            ['id'=>92,'name'=>'Fahéj','isFruit'=>false,'kcalPerGram'=>2.47],
            ['id'=>93,'name'=>'Vanília','isFruit'=>false,'kcalPerGram'=>2.88],
            ['id'=>94,'name'=>'Kakaópor','isFruit'=>false,'kcalPerGram'=>2.28],
            ['id'=>95,'name'=>'Étcsokoládé','isFruit'=>false,'kcalPerGram'=>5.46],
        ];

        foreach ($ingredients as $ingredient) {
            Ingredients::create($ingredient);
        }

        // Receptek
        $recipes = [
            ['id' => 1, 'name' => 'Csirkemell rizzsel', 'userId' => 1, 'imageUrl' => ''],
            ['id' => 2, 'name' => 'Banános turmix', 'userId' => 1, 'imageUrl' => ''],
            ['id' => 3, 'name' => 'Paradicsomos omlett', 'userId' => 1, 'imageUrl' => ''],
            ['id' => 4, 'name' => 'Protein shake B-version', 'userId' => 2, 'imageUrl' => ''],
        ];

        foreach ($recipes as $recipe) {
            Recipe::create($recipe);
        }

        //Kommentek
        $comments = [
            ['id' => 1, 'content' => 'Nagyon finom lett, köszi!', 'recipeId' => 1, 'userId' => 2],
            ['id' => 2, 'content' => 'Ez a turmix brutál jó lett!', 'recipeId' => 2, 'userId' => 2],
            ['id' => 3, 'content' => 'Remek reggeli ötlet, köszönöm!', 'recipeId' => 3, 'userId' => 2],
            ['id' => 4, 'content' => 'Ez a protein shake nagyon jól sikerült!', 'recipeId' => 4, 'userId' => 1],
        ];

        foreach ($comments as $comment) {
            Comment::create($comment);
        }

        //Inventory
        $userIngredients = [
            ['userId' => 1, 'ingredientId' => 1, 'gramAmount' => 500],
            ['userId' => 1, 'ingredientId' => 3, 'gramAmount' => 800],
            ['userId' => 1, 'ingredientId' => 4, 'gramAmount' => 1000],
            ['userId' => 1, 'ingredientId' => 6, 'gramAmount' => 200],
            ['userId' => 2, 'ingredientId' => 2, 'gramAmount' => 300],
            ['userId' => 2, 'ingredientId' => 5, 'gramAmount' => 400],
            ['userId' => 2, 'ingredientId' => 7, 'gramAmount' => 1000],
            ['userId' => 2, 'ingredientId' => 8, 'gramAmount' => 500],
        ];

        DB::table('user_ingredient')->insert($userIngredients);

        //Recepthez Hozzávalók

        $ingredientRecipes = [
            ['ingredientId' => 3, 'recipeId' => 1, 'gramAmount' => 300],
            ['ingredientId' => 4, 'recipeId' => 1, 'gramAmount' => 200],
            ['ingredientId' => 5, 'recipeId' => 1, 'gramAmount' => 100],
            ['ingredientId' => 2, 'recipeId' => 2, 'gramAmount' => 150],
            ['ingredientId' => 6, 'recipeId' => 2, 'gramAmount' => 50],
            ['ingredientId' => 6, 'recipeId' => 3, 'gramAmount' => 120],
            ['ingredientId' => 5, 'recipeId' => 3, 'gramAmount' => 80],
            ['ingredientId' => 2, 'recipeId' => 4, 'gramAmount' => 120],
            ['ingredientId' => 8, 'recipeId' => 4, 'gramAmount' => 30],
            ['ingredientId' => 6, 'recipeId' => 4, 'gramAmount' => 70],
        ];

        DB::table('ingredient_recipe')->insert($ingredientRecipes);

    }
}
