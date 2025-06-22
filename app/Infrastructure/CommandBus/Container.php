<?php

namespace App\Infrastructure\CommandBus;

interface Container
{
    /**
     * Return a new instance of an object
     *
     * @param string $class
     * @return mixed
     */
    public function make(string $class): mixed;
}
