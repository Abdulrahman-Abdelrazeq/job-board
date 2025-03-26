<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Attribute;

class AttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $attributes = [
            ['name' => 'years_experience', 'type' => 'number', 'options' => null],
            ['name' => 'seniority_level', 'type' => 'select', 'options' => json_encode(['Junior', 'Mid-Level', 'Senior'])],
            ['name' => 'remote_work', 'type' => 'boolean', 'options' => null],
        ];

        foreach ($attributes as $attribute) {
            Attribute::create($attribute);
        }
    }
}
