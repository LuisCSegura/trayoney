<?php

namespace Database\Factories;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Category;
use App\Models\Account;

class TransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Transaction::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'account_id' => Account::factory(),
            'category_id' => NULL,
            'destination_account_id' => NULL,
            'detail' => $this->faker->sentence,
            'amount' => $this->faker->randomFloat(NULL, $min = 1, $max = 10000000),
            'type' => $this->faker->randomElement(['INCOME', 'EXPENSE', 'TRANSFER']),
            'updated_at' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
        ];
    }
}
