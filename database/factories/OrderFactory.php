<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Address;
use App\Models\Area;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\PaymentMethod;
use App\Models\User;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $is_gift = $this->faker->boolean(20);
        $gift_recipient_name = $is_gift ? $this->faker->name() : "";
        $gift_recipient_address = $is_gift ? $this->faker->address() : "";
        return [
            'user_id' => User::pluck('id')->random(),
            'coupon_id' => Coupon::pluck('id')->random(),
            'address_id' => Address::pluck('id')->random(),
            'area_id' => Area::pluck('id')->random(),
            'payment_method_id' => PaymentMethod::pluck('id')->random(),
            'total_amount' => $this->faker->randomFloat(0, 0, 500.),
            'status' => $this->faker->randomElement(['processing','shipped','completed','cancelled','refunded','declined']),
            'is_gift' => $is_gift,
            'gift_recipient_name' => $gift_recipient_name,
            'gift_recipient_address' => $gift_recipient_address,
            'notes' => $this->faker->text(),
        ];
    }
}
