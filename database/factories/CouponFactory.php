<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Coupon;

class CouponFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Coupon::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'code' => $this->faker->word(),
            'status' => $this->faker->boolean(),
            'description' => $this->faker->sentence(),
            'discount_value' => $this->faker->numberBetween(50,75),
            'discount_type' => $this->faker->randomElement(['value','percent']),
            'valid_from' => $this->faker->dateTime(),
            'valid_to' => $this->faker->dateTime(),
        ];
    }
}
