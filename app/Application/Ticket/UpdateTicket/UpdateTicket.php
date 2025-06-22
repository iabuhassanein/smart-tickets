<?php

declare(strict_types=1);

namespace App\Application\Ticket\UpdateTicket;

use App\Infrastructure\CommandBus\Command;
use App\Models\Ticket\Ticket;

class UpdateTicket implements Command
{
    /**
     * @var Ticket
     */
    private Ticket $ticket;
    /**
     * @var array
     */
    private array $data;

    /**
     * @param Ticket $ticket
     * @param array $data
     */
    public function __construct(Ticket $ticket, array $data)
    {
        $this->setTicket($ticket);
        $this->setData($data);
    }
    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData(array $data): void
    {
        $this->data = $data;
    }

    public function getTicket(): Ticket
    {
        return $this->ticket;
    }

    public function setTicket(Ticket $ticket): void
    {
        $this->ticket = $ticket;
    }

}
