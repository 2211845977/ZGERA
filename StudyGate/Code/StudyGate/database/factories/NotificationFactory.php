<?php

namespace Database\Factories;

use App\Models\Notification;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notification>
 */
class NotificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $types = ['lecture', 'announcement', 'task'];
        return [
            'type' => $this->faker->randomElement($types),
            'title' => $this->faker->sentence,
            'body' => $this->faker->paragraph,
            'user_id' => null,
            'is_read' => false,
        ];
    }
}
