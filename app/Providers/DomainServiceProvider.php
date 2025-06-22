<?php

namespace App\Providers;

use App\Domain\AITicketClassifier\TicketClassifierInterface;
use App\Services\TicketClassifier;
use Illuminate\Support\ServiceProvider;

class DomainServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app->singleton(TicketClassifierInterface::class, TicketClassifier::class);
    }
}
