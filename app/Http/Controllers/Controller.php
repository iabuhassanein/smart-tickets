<?php

namespace App\Http\Controllers;
use App\Infrastructure\CommandBus\CommandDispatcher;

abstract class Controller
{
    use CommandDispatcher;
}
