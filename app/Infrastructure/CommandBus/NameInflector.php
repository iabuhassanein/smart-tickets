<?php

namespace App\Infrastructure\CommandBus;

class NameInflector implements Inflector
{
    /**
     * Find a Handler for a Command
     *
     * @param Command $command
     * @return string
     */
    public function inflect(Command $command): string
    {
        return get_class($command) . 'Handler';
    }
}
