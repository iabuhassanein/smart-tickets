<?php

declare(strict_types=1);

namespace App\Application\Ticket\GetTicket;

use App\Infrastructure\CommandBus\Command;

class GetTicket implements Command
{
    /**
     * @var string
     */
    private string $id;

    /**
     * @param string $id
     */
    public function __construct(string $id)
    {
        $this->setId($id);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }

}
