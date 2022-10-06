<?php

use Illuminate\Database\Seeder;
use App\Models\Publicity;

class PublicitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $publicities = config('db.publicities');

        foreach ($publicities as $publicity) {
            $new_pub = new Publicity();
            $new_pub->type = $publicity['type'];
            $new_pub->price = $publicity['price'];
            $new_pub->duration = $publicity['duration'];
            $new_pub->save();
        };
    }
}