<?php

namespace App\Infrastructure\CommandBus;

interface Handler
{
    /**
     * Handle a Command object
     *
     * @param Command $command
     * @return mixed
     */
    public function handle(Command $command): mixed;
}
