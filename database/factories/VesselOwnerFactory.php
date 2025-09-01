<?php

namespace Database\Factories;

use App\Models\ProfileUser;
use Helper;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProfileUser>
 */
class VesselOwnerFactory extends Factory
{
    protected $model = ProfileUser::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Generate the first two digits (not in the range of 20-50)
        do {
            $first_two_digits = $this->faker->numberBetween(1, 99); // Get a random number between 1 and 99
        } while ($first_two_digits > 7 && $first_two_digits < 50); // Ensure it's not between 20 and 50

        // Generate the rest of the digits
        $ref = str_pad($first_two_digits, 2, '0', STR_PAD_LEFT) . $this->faker->unique()->numerify('############');

        // Malay names list
        $first_names = ['Ahmad bin', 'Ali bin', 'Siti binti', 'Noraini binti', 'Aishah binti', 'Kamal bin', 'Fahmi bin', 'Zulfiqar bin'];
        $last_names = ['Ali', 'Ahmad', 'Omar', 'Ibrahim', 'Hisham', 'Hasan'];

        return [
            'id' => Str::uuid(), // Generates a UUID
            'user_id' => null, // User ID is null
            'type_id' => $this->faker->randomElement([
                Helper::getCodeMasterIdByTypeName('user_type', 'PEMOHON LESEN VESEL (NELAYAN LAUT)'),
                Helper::getCodeMasterIdByTypeName('user_type', 'PEMOHON LESEN VESEL (NELAYAN DARAT)'),
            ]), // Dynamically fetch type_id
            'ref' => $ref, //$this->faker->unique()->numerify('############'), // 12-digit unique reference
            'name' => $this->faker->randomElement($first_names).' '.$this->faker->randomElement($last_names), //$this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone_code' => '60', // Fixed country code for Malaysia
            'phone' => $this->faker->regexify('[1-9][0-9]{8,9}'), // 9 or 10 digits, not starting with 0
            'is_bumiputera' => $this->faker->boolean(),
        ];
    }
}
