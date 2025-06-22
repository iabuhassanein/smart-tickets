<?php

declare(strict_types=1);

namespace App\Application\Ticket\UpdateTicket;

use App\Infrastructure\CommandBus\Command;
use App\Infrastructure\CommandBus\CommandDispatcher;
use App\Infrastructure\CommandBus\Handler;
use App\Models\Ticket\Ticket;
use App\Models\Ticket\TicketCategory;
use App\Models\Ticket\TicketStatus;

class UpdateTicketHandler implements Handler
{
    use CommandDispatcher;

    /**
     * Handle a Command object
     * @param UpdateTicket $command
     * @return Ticket
     */
    public function handle(Command $command): Ticket
    {
        $ticket = $command->getTicket();
        $data = $command->getData();

        // Please note, this is an internal command that'd allow to update each single property of a ticket model,
        // that's not mean allow external user/api to update everything.
        if (!empty($data['subject'])) $ticket->setSubject($data['subject']);
        if (!empty($data['body'])) $ticket->setBody($data['body']);
        if (!empty($data['status'])) $ticket->setStatus(TicketStatus::getStatusEnum($data['status']));
        if (!empty($data['category'])) $ticket->setCategory(TicketCategory::getCategoryEnum($data['category']));
        if (!empty($data['confidence'])) $ticket->setConfidence(floatval($data['confidence']));
        if (!empty($data['explanation'])) $ticket->setExplanation($data['explanation']);
        if (!empty($data['note'])) $ticket->setNote($data['note']);
        if (isset($data['isOverride']) && is_bool($data['isOverride'])) $ticket->setIsOverride(boolval($data['isOverride']));
        $ticket->save();

        return $ticket;
    }
}
