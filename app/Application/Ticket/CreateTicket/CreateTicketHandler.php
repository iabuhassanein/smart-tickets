<?php

declare(strict_types=1);

namespace App\Application\Ticket\CreateTicket;

use App\Infrastructure\CommandBus\Command;
use App\Infrastructure\CommandBus\CommandDispatcher;
use App\Infrastructure\CommandBus\Handler;
use App\Models\Ticket\Ticket;
use App\Models\Ticket\TicketStatus;

class CreateTicketHandler implements Handler
{
    use CommandDispatcher;

    /**
     * Handle a Command object
     * @param CreateTicket $command
     * @return Ticket
     */
    public function handle(Command $command): Ticket
    {
        $data = $command->getData();

        $ticket = new Ticket();
        $ticket->setSubject($data['subject']??'');
        $ticket->setBody($data['body']??'');
        $ticket->setStatus(TicketStatus::NEW);
        $ticket->setCategory(null);
        $ticket->setConfidence(0);
        $ticket->setExplanation('');
        $ticket->setNote($data['note']??'');
        $ticket->setIsOverride(false);
        $ticket->save();

        return $ticket;
    }
}
