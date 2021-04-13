<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;


class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'category_id' => NULL,
            'name' => $this->faker->word,
            'amount' => $this->faker->randomFloat(2, $min = 1, $max = 10000000),
            'is_income' => $this->faker->randomElement([true, false]),
        ];
    }
}
