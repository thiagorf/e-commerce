<?php

namespace Database\Factories;

use App\Models\CreditCard;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class CreditCardFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CreditCard::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'card_number' => 1111111111111111,
            'cvv' => 444,
            'owner' => 'John',
            'expiry_date' => Carbon::now()->toDateString()
        ];
    }
}
