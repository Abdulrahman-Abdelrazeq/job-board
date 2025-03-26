<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Job;
use App\Models\Location;

class JobLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jobs = Job::all();
        $locations = Location::all();

        foreach ($jobs as $job) {
            $job->locations()->syncWithoutDetaching(
                $locations->random(rand(1, 3))->pluck('id')->toArray()
            );
        }
    }
}
