<?php

namespace App\Infrastructure\CommandBus;

use Illuminate\Contracts\Container\BindingResolutionException;

trait CommandDispatcher
{
    /**
     * @param Command $command
     * @return mixed
     * @throws BindingResolutionException
     */
    protected function dispatchCommand(Command $command): mixed
    {
        /** @var CommandBus $dispatcher */
        $dispatcher = app()->make(CommandBus::class);
        return $dispatcher->execute($command);
    }
}
