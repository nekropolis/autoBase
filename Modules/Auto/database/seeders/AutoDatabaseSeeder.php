<?php

namespace Modules\Auto\Database\Seeders;

use Illuminate\Database\Seeder;

class AutoDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([ComponentSeeder::class]);
    }
}
