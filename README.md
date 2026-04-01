# ReceptPlus
Ez a projekt egy webalkalmazás, amely lehetővé teszi a felhasználók számára, hogy megosszák kedvenc receptjeiket, értékeljék mások ételeit, és új recepteket fedezzenek fel.

Fő funkciók:

Receptek feltöltése és értékelése
Alapanyagkövetés (otthoni készletek kezelése)
Automatikus receptajánló meglévő hozzávalók alapján
Kalóriaszámítás receptekhez

A rendszer célja, hogy segítse a tudatosabb és fenntarthatóbb étkezést, valamint közösségi élményt nyújtson.

Telepítés és futtatás

Előfeltételek:

XAMPP (Apache + MySQL)
PHP
Composer
Node.js és npm
Angular CLI
Visual Studio Code (ajánlott)

Backend (Laravel) indítása:

php artisan migrate --seed
rm -rf public/storage
php artisan storage:link
php artisan serve

Frontend (Angular) indítása:

npm install
ng serve

Alkalmazás webcíme: http://localhost:4200

XAMPP beállítás:

Indítsd el a XAMPP Control Panelt
Kapcsold be az Apache és MySQL modulokat
