<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        $subtotal = $this->faker->randomFloat(2, 20, 500);
        $tax = $subtotal * 0.1;
        $shipping = $this->faker->randomFloat(2, 5, 20);
        
        return [
            'user_id' => User::factory(),
            'order_number' => 'ORD-' . strtoupper($this->faker->unique()->bothify('????????')),
            'status' => $this->faker->randomElement(['pending', 'processing', 'shipped', 'completed', 'cancelled']),
            'subtotal' => $subtotal,
            'tax_amount' => $tax,
            'shipping_amount' => $shipping,
            'total_amount' => $subtotal + $tax + $shipping,
            'shipping_address' => json_encode([
                'address' => $this->faker->streetAddress(),
                'city' => $this->faker->city(),
                'state' => $this->faker->state(),
                'zip' => $this->faker->postcode(),
                'country' => 'USA',
            ]),
            'billing_address' => json_encode([
                'address' => $this->faker->streetAddress(),
                'city' => $this->faker->city(),
                'state' => $this->faker->state(),
                'zip' => $this->faker->postcode(),
                'country' => 'USA',
            ]),
            'payment_method' => 'stripe',
            'payment_status' => $this->faker->randomElement(['pending', 'completed', 'failed', 'refunded']),
            'payment_reference' => 'pi_' . $this->faker->bothify('????????????????????'),
        ];
    }
}

