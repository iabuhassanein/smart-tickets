<?php

namespace App\Infrastructure\CommandBus;

interface Inflector
{
    /**
     * Find a Handler for a Command
     *
     * @param Command $command
     * @return string
     */
    public function inflect(Command $command): string;
}
