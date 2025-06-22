<?php

namespace App\Http\Resources\Ticket;

use App\Models\Ticket\Ticket;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var Ticket $instance */
        $instance = $this->resource;

        return [
            'id' => $instance->getId(),
            'subject' => $instance->getSubject(),
            'body' => $instance->getBody(),
            'status' => $this->when(!!$instance->getStatus(), TicketStatusResource::make($instance->getStatus())),
            'category' => $this->when(!!$instance->getCategory(), TicketStatusResource::make($instance->getCategory()), null),
            'confidence' => $instance->getConfidence(),
            'explanation' => $instance->getExplanation(),
            'note' => $instance->getNote(),
            'isOverride' => $instance->isOverride(),
            'createdAt' => $instance->getCreatedAt(),
        ];
    }
}
