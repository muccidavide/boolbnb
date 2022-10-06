<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Generator as Faker;
use App\Models\Apartment;

class ApartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i = 0; $i < 20; $i++) {
            $apartment = new Apartment;
            $apartment->title = $faker->sentence(4);
            $apartment->slug = Str::slug($apartment->title, '-');
            $apartment->thumb = 'apartment_images/apartment-1.webp';
            $apartment->description = $faker->text(500);
            $apartment->address = "Via Rodolfo Morandi 15, 20090 Buccinasco";
            $apartment->lat = 45.42327;
            $apartment->lon = 9.12977;
            $apartment->rooms = $faker->numberBetween(1, 20);
            $apartment->baths = $faker->numberBetween(1, 20);
            $apartment->beds = $faker->numberBetween(1, 20);
            $apartment->sqm = $faker->numberBetween(10, 1000);
            $apartment->user_id = 1;
            $apartment->save();
        }
    }
}