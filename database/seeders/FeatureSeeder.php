<?php

namespace Database\Seeders;

use App\Models\Feature;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $features = [
            ['name' => 'user'],
            ['name' => 'role'],
            ['name' => 'product'],
            ['name' => 'permissions'],
            ['name' => 'features'],
        ];
        foreach($features as $new_feature) {
            $feature = new Feature();
            $feature->name = $new_feature['name'];
            $feature->save();
        }
    }
}
