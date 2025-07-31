<?php

namespace Modules\Auto\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Auto\Models\Component;

class ComponentSeeder extends Seeder
{
    public function run()
    {
        $components = file(storage_path('app/components.csv'), FILE_IGNORE_NEW_LINES);

        foreach ($components as $name) {
            Component::create([
                'name' => $name,
            ]);
        }
    }
}
