<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Models\Message;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i = 0; $i < 5; $i++) {
            $new_mex = new Message();
            $new_mex->full_name = $faker->words(2, true);
            $new_mex->email = $faker->email();
            $new_mex->subject = $faker->sentence(5);
            $new_mex->content = $faker->text();
            $new_mex->save();
        }
    }
}