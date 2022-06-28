<?php

namespace Database\Seeders;

use App\Models\Certificate;
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
        $this->call([

        ]);
        //\App\Models\User::factory(400)->create();
//        Establishment::factory(400)->create();
        Certificate::factory(200)->create();
    }
}
