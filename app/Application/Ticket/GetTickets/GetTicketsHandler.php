<?php

declare(strict_types=1);

namespace App\Application\Ticket\GetTickets;

use App\Infrastructure\CommandBus\Command;
use App\Infrastructure\CommandBus\CommandDispatcher;
use App\Infrastructure\CommandBus\Handler;
use App\Models\Ticket\Ticket;
use Illuminate\Pagination\LengthAwarePaginator;

class GetTicketsHandler implements Handler
{
    use CommandDispatcher;

    protected int $perPage = 10;

    /**
     * Handle a Command object
     * @param GetTickets $command
     * @return LengthAwarePaginator
     */
    public function handle(Command $command): LengthAwarePaginator
    {
        $page = $command->getPage();
        $search = $command->getSearch();
        $filters = $command->getFilters();

        return Ticket::query()->search($search)->filters($filters)->latest()->paginate($this->perPage, ['*'], 'page', $page);
    }
}
