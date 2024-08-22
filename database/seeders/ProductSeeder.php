<?php

namespace Database\Seeders;

use App\Models\Category;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 50) as $index) {
            DB::table('products')->insert([
                'name' => $faker->word,
                'description' => $faker->paragraph,
                'price' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 100),
                'category_id' => Category::inRandomOrder()->get()->first()->id,
            ]);
        }
    }
}
