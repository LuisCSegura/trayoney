<?php

namespace Database\Factories;

use App\Models\Account;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Currency;



class AccountFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Account::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'currency_id' => Currency::factory(),
            'abbreviation' => $this->faker->randomElement(array('BCR EUR', 'BN CRC', 'Coocique USD')),
            'name' => $this->faker->word,
            'balance' => $this->faker->randomFloat(NULL, $min = 1, $max = 1000000000),
            'is_debit' => true,
        ];
    }
}
