<?php

namespace App\Jobs;

use App\Application\Ticket\UpdateTicket\UpdateTicket;
use App\Domain\AITicketClassifier\TicketClassifierInterface;
use App\Infrastructure\CommandBus\CommandDispatcher;
use App\Jobs\Middleware\JobThrottlingMiddleware;
use App\Models\Ticket\Ticket;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Cache;

class ClassifyTicket implements ShouldQueue
{
    use Queueable, CommandDispatcher;

    protected Ticket $ticket;
    /**
     * Create a new job instance.
     */
    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    /**
     * Execute the job.
     * @throws BindingResolutionException
     */
    public function handle(TicketClassifierInterface $service): void
    {
        $response = $service->classifyTicket($this->ticket);
        if ($response['success']) {
            $this->dispatchCommand(new UpdateTicket($this->ticket, [
                'category' => $response['category'],
                'explanation' => $response['explanation'],
                'confidence' => $response['confidence'],
                'isOverride' => false
            ]));

            Cache::put("ticket_classification_{$this->ticket->getId()}", 'finished', 300); // 5 minutes TTL
        }
    }

    /**
     * Get the middleware the job should pass through.
     * It's used for limiting
     * @return array
     */
    public function middleware(): array
    {
        return [new JobThrottlingMiddleware];
    }
}
