<?php

namespace App\Domain\AITicketClassifier;

use App\Models\Ticket\Ticket;

interface TicketClassifierInterface
{
    /**
     * @param Ticket $ticket
     */
    public function classifyTicket(
        Ticket $ticket
    ): array;
}
