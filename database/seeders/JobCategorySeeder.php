<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Job;
use App\Models\Category;

class JobCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jobs = Job::all();
        $categories = Category::all();

        foreach ($jobs as $job) {
            $job->categories()->syncWithoutDetaching(
                $categories->random(rand(1, 3))->pluck('id')->toArray()
            );
        }
    }
}
