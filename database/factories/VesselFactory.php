<?php

namespace Database\Factories;

use App\Models\Entity;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vessel>
 */
class VesselFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => Str::uuid(),
            'entity_id' => Entity::query()->inRandomOrder()->value('id'),
            'vessel_no' => $this->faker->regexify('[A-Z]{3} \d{5}'),
            'zone' => $this->faker->randomElement(['A', 'B', 'C', 'C2', 'C3']),
            'start_date' => $this->faker->dateTimeBetween('-2 years', 'now'),
            'end_date' => $this->faker->dateTimeBetween('now', '+2 years'),
            'is_active' => true,
        ];
    }
}
