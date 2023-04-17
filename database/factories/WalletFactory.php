<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Wallet>
 */
class WalletFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $currencies = config('wallets.currencies');
        $oneOf = fake()->randomElement(array_keys(config('wallets.currencies')));
        return [
            'address' => fake()->bankAccountNumber(),
            'type' =>  $currencies[$oneOf],
        ];
    }
}
