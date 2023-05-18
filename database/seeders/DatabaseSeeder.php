<?php

namespace Database\Seeders;

use App\Models\Award;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        Award::create(
            [
                "ExternalId" => "1",
                "operatorId" => "10",
                "type" => "points",
                "subType" => "1000 points",
                "name" => " 1000 نقطة مقدمة من سيراتيل",
            ]
        );

        // Award::destroy(Award::all());
    }
}
