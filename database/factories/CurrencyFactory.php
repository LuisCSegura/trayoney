<?php

namespace Database\Factories;

use App\Models\Currency;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class CurrencyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Currency::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'abbreviation' => $this->faker->randomElement(array('EUR', 'CRC', 'USD')),
            'name' => $this->faker->word,
            'simbol' => $this->faker->randomElement(array('€', '₡', '$')),
            'rate' => $this->faker->randomFloat(NULL, $min = 1, $max = 1000),
        ];
    }
}
