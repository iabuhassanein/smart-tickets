<?php

namespace App\Http\Resources\Ticket;

use App\Models\Ticket\Ticket;
use App\Models\Ticket\TicketStatus;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketStatusResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var TicketStatus $instance */
        $instance = $this->resource;

        return [
            'value' => $instance->value,
            'label' => $instance->label(),
        ];
    }
}
