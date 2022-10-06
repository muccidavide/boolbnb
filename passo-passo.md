# Passo passo progetto di team - Boolbnb:

## 14/07:
1. Installare laravel:
- composer create-project --prefer-dist laravel/laravel:^7.0 (nomeFile);

2. Installare dipendenze:
- npm i;

3. Installare Bootstrap:
- npm i bootstrap;

4. Installare laravel UI (per log-in e signin):
- composer require laravel/ui:^2.4;
- php artisan ui vue --auth;
- npm i && npm run dev;

5. Lanciare il programma e watch:
- php artisan serve;
- npm run watch;

6. Per usare Bootstrap 5 invece di 4 controllare => "devDependencies" in package.json:
- cambiare "bootstrap": "^4.0.0" in "bootstrap": "^5.0.0". 
- rilanciare npm i;
- php artisan serve;
- npm run watch;
(Prova del nove => Public->css->app.css deve esserci scritto: Bootstrap v5.1.3 (https://getbootstrap.com/)).

### Inizializzazione per chi clona
1. Clonare il progetto e installare:
- crea .env e sitstema il db
- npm i
- composer i
- npm install vue-router@3
- npm run watch
- php artisan serve;

### Nuovo DB:
1. Lanciare mysql:
- mysql -uroot -proot;

2. Creare database:
- create database (nomeDatabase);

3. Imposta dati per mysql in .env

### Creazione Modelli:

Generate folder structure:
app->http->controllers add "Admin" folder;
all'interno di questa cartella andranno inseriti i modelli

Create model, controller, migration and seed:
You can use this => php artisan make:model Models/(Modelname) -a

Modelli creati:
Tutti i modelli creati o modificati andranno inseriti in Models, cambiandone il namespace Models/NomeModello
Apartament,
Service,
Message,
View,
User (modificato namespace appropriati in registercontroller, config->auth-> "'model' => App\Models\User::class"),
{on config/auth.php. There under “providers” update the user model from “App\User” to “App\Models\User“}
Publicity;

!!!Rememeber Route in web.php!!!
Creiamo il gruppo di rotte nella middleware, nella quale andranno inserite tutte le rotte soggette a login
Route::middleware('auth')->prefix('admin')->namespace('Admin')->name('admin.')->group(function () {
    // Admin Dashboard
    Route::get('/', 'HomeController@index')->name('home');
});

### Implementato le migrazioni con i propri campi di riferimento:

Modificato campi migrations->users_table:
 Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

Modificato campi migrations->apartments_table:
Schema::create('apartments', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->string('slug');
            $table->string('thumb');
            $table->text('description')->nullable();
            $table->tinyInteger('rooms')->nullable();
            $table->tinyInteger('beds')->nullable();
            $table->tinyInteger('baths')->nullable();
            $table->smallInteger('sqm')->nullable();
            $table->string('address');
            $table->decimal('lon', 12, 9)->nullable();
            $table->decimal('lat', 12, 9)->nullable();
            $table->boolean('visibility')->default(true);
            $table->timestamps();
        });
Il resto delle migrazioni sono state modificate allo stesso modo con i parametri specifici


### Implementazione dati attraverso i seeder:

Inserire use per sfruttare le funzioni specifiche
use Illuminate\Support\Str;
use Faker\Generator as Faker;
use App\Models\Apartment;

Inserire ciclo for per immettere i dati mediante faker
!!ATTENZIONE!! ricordare di inserire nel parametro della funzione "Faker $faker"
Di seguito abbiamo il ciclo for per immettere i "dati fittizzi" nel database

```php

    public function run(Faker $faker)
    {
        for ($i = 0; $i < 20; $i++) {
            $apartment = new Apartment;
            $apartment->title = $faker->sentence(4);
            $apartment->slug = Str::slug($apartment->title, '-');
            $apartment->thumb = $faker->imageUrl(600, 400, 'thumb_apartment', true, 'thumb', true, 'jpg');
            $apartment->description = $faker->text(500);
            $apartment->address = $faker->address();
            $apartment->save();
        }
    }
```

Successivamente runnare nel terminale il comando per seedare il db: "php artisan db:seed" ----> se compare qualche errore runnare "composer dump-autoload"