<?php

use Illuminate\Database\Seeder;
use App\Models\View;
use Faker\Generator as Faker;

class ViewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i = 0; $i < 50; $i++) {
            $new_view = new View();
            $new_view->ip_address = $faker->ipv4();
            $new_view->date = $faker->date();
            $new_view->save();
        }
    }
}