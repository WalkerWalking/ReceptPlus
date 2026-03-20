<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;

// Az eredeti "inspire" parancs maradjon meg
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// A TE TESZT PARANCSOD (Extra csomag nélkül!)
Artisan::command('send-mail', function () {
    $this->info('Levél küldése folyamatban a Mailtrap-re...');

    try {
        Mail::raw('Szia! Ez egy teszt e-mail, amit extra 3rd party csomag nélkül küldtünk a Laravel beépített rendszerével!', function ($message) {
            $message->to('788danibari@gmail.com')
                    ->subject('Laravel Beépített Teszt');
        });

        $this->info('SIKER! A levelet elküldtük. Ellenőrizd a Mailtrap fiókodat!');
    } catch (\Exception $e) {
        $this->error('HIBA TÖRTÉNT: ' . $e->getMessage());
        $this->comment('Tipp: Ellenőrizd a .env fájlban az adataidat!');
    }
})->purpose('Teszt e-mail küldése');