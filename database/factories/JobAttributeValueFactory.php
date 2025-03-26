<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Job;
use App\Models\Attribute;

class JobAttributeValueFactory extends Factory
{
    public function definition(): array
    {
        $attribute = Attribute::inRandomOrder()->first(); // اختيار Attribute عشوائي
        $value = $this->generateValueBasedOnType($attribute);

        return [
            'job_id' => Job::inRandomOrder()->first()->id,
            'attribute_id' => $attribute->id,
            'value' => $value,
        ];
    }

    private function generateValueBasedOnType($attribute)
    {
        switch ($attribute->type) {
            case 'number':
                return fake()->numberBetween(1, 20); // سنوات الخبرة بين 1 و 20
            case 'select':
                $options = json_decode($attribute->options, true);
                return $options ? fake()->randomElement($options) : null;
            case 'boolean':
                return fake()->boolean() ? 'true' : 'false'; // يتم تخزينها كنص
            default:
                return null;
        }
    }
}
