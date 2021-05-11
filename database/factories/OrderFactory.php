<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use App\Models\CreditCard;
use Illuminate\Database\Eloquent\Factories\Factory;

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
     *
     * @return array
     */
    public function definition()
    {
        return [
            'credit_card_id' => 1,
            'user_id' => User::factory()->create()->id,
            // 'qty' => 3
        ];
    }
}
