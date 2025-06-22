<?php

namespace Database\Factories\Ticket;

use App\Models\Ticket\Ticket;
use App\Models\Ticket\TicketCategory;
use App\Models\Ticket\TicketStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $statuses = TicketStatus::getStatusKeysList();
        $categories = TicketCategory::getCategoryKeysList();
        return [
            'subject' => fake()->text(150),
            'body' => fake()->text(500),
            'status' => $statuses[array_rand($statuses)],
            'category' => $categories[array_rand($categories)],
            'confidence' => rand(50, 100) / 100,
            'explanation' =>  fake()->text(300),
            'note' =>  fake()->text(150),
            'isOverride' =>  fake()->boolean(),
        ];
    }
}
