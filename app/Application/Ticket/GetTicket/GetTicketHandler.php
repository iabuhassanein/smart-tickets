<?php

declare(strict_types=1);

namespace App\Application\Ticket\GetTicket;

use App\Infrastructure\CommandBus\Command;
use App\Infrastructure\CommandBus\CommandDispatcher;
use App\Infrastructure\CommandBus\Handler;
use App\Models\Ticket\Ticket;
use Illuminate\Pagination\LengthAwarePaginator;

class GetTicketHandler implements Handler
{
    use CommandDispatcher;

    /**
     * Handle a Command object
     * @param GetTicket $command
     * @return Ticket
     */
    public function handle(Command $command): Ticket
    {
        $id = $command->getId();
        return Ticket::query()->findOrFail($id);
    }
}
