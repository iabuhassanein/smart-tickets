<?php

namespace App\Http\Controllers\Api;

use App\Application\Ticket\CreateTicket\CreateTicket;
use App\Application\Ticket\GetTickets\GetTickets;
use App\Application\Ticket\GetTicket\GetTicket;
use App\Application\Ticket\UpdateTicket\UpdateTicket;
use App\Domain\AITicketClassifier\TicketClassifierInterface;
use App\Helpers\ResponseHelper;
use App\Http\Requests\Ticket\StoreTicketRequest;
use App\Http\Requests\Ticket\UpdateTicketRequest;
use App\Http\Resources\Ticket\TicketCollection;
use App\Http\Resources\Ticket\TicketResource;
use App\Jobs\ClassifyTicket;
use App\Models\Ticket\Ticket;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

/**
 *
 */
class TicketController extends BaseController
{
    /**
     *
     */
    function __construct()
    {
        parent::__construct();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws BindingResolutionException
     */
    public function index(Request $request): JsonResponse
    {
        /** @var Ticket[]|Collection $list */
        $list = $this->dispatchCommand(new GetTickets($request->get('page')??1, $request->get('search')??"", $request->get('filters')??[]));
        return $this->response(['status' => ResponseHelper::RESPONSE_STATUS_OK, 'result' => TicketCollection::make($list)]);
    }

    /**
     * @param Request $request
     * @param string|null $id
     * @return JsonResponse
     * @throws BindingResolutionException
     */
    public function get(Request $request, ?string $id): JsonResponse
    {
        /** @var Ticket $ticket */
        $ticket = $this->dispatchCommand(new GetTicket($id??''));
        return $this->response(['status' => ResponseHelper::RESPONSE_STATUS_OK, 'result' => TicketResource::make($ticket)]);
    }

    /**
     * @param StoreTicketRequest $request
     * @return JsonResponse
     * @throws BindingResolutionException
     */
    public function store(StoreTicketRequest $request): JsonResponse
    {
        /** @var Ticket $ticket */
        $ticket = $this->dispatchCommand(new CreateTicket($request->only(['subject', 'body'])));
        return $this->response(['status' => ResponseHelper::RESPONSE_STATUS_OK, 'result' => TicketResource::make($ticket)]);
    }

    /**
     * @param UpdateTicketRequest $request
     * @param string|null $id
     * @return JsonResponse
     * @throws BindingResolutionException
     */
    public function update(UpdateTicketRequest $request, ?string $id): JsonResponse
    {
        /** @var Ticket $ticket */
        $ticket = $this->dispatchCommand(new GetTicket($id??''));
        $isOverride = $ticket->getCategory()?->value !== $request->get('category');
        $ticket = $this->dispatchCommand(new UpdateTicket($ticket, [...$request->only(['status', 'category', 'note']), 'isOverride' => $isOverride]));
        return $this->response(['status' => ResponseHelper::RESPONSE_STATUS_OK, 'result' => TicketResource::make($ticket)]);
    }

    /**
     * @param Request $request
     * @param string|null $id
     * @return JsonResponse
     * @throws BindingResolutionException
     */
    public function classify(Request $request, ?string $id): JsonResponse
    {
        /** @var Ticket $ticket */
        $ticket = $this->dispatchCommand(new GetTicket($id??''));
        dispatch(new ClassifyTicket($ticket));
        Cache::put("ticket_classification_{$ticket->getId()}", 'processing', 300); // 5 minutes TTL

        return $this->response(['status' => ResponseHelper::RESPONSE_STATUS_OK, 'result' => 'Ticket classifying is under process.']);
    }

    /**
     * @param Request $request
     * @param string|null $id
     * @return JsonResponse
     * @throws BindingResolutionException
     */
    public function checkClassification(Request $request, ?string $id): JsonResponse
    {
        $status = Cache::get("ticket_classification_{$id}");
        $ticket = null;
        if ($status === 'finished') {
            /** @var Ticket $ticket */
            $ticket = $this->dispatchCommand(new GetTicket($id??''));
        }
        return $this->response(['status' => ResponseHelper::RESPONSE_STATUS_OK,
            'result' => ['isFinished' => $status === 'finished', 'ticket' => $ticket?TicketResource::make($ticket):null]]);
    }
}
