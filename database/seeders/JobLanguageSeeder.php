<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Job;
use App\Models\Language;

class JobLanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jobs = Job::all();
        $languages = Language::all();

        foreach ($jobs as $job) {
            // Select random languages and ensure they are unique
            $selectedLanguages = $languages->random(rand(1, 3))->pluck('id')->unique()->toArray();

            // Attach the languages to the job
            $job->languages()->syncWithoutDetaching($selectedLanguages);
        }
    }
}
