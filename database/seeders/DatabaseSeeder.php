<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            LanguageSeeder::class,
            LocationSeeder::class,
            CategorySeeder::class,
            AttributeSeeder::class,
            JobSeeder::class,
            JobAttributeValueSeeder::class,
            JobLanguageSeeder::class,
            JobLocationSeeder::class,
            JobCategorySeeder::class,
        ]);
    }
}
