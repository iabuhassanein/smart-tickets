<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Models\Ticket\Ticket;
use App\Models\Ticket\TicketCategory;
use App\Models\Ticket\TicketStatus;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashboardController extends BaseController
{
    /**
     * Get dashboard statistics
     */
    public function getStatistics(): JsonResponse
    {
        $ticketsByStatus = [];
        foreach (TicketStatus::cases() as $status) {
            $ticketsByStatus[$status->value] = Ticket::query()->where('status', $status->value)->count();
        }

        $ticketsByCategory = [];
        foreach (TicketCategory::cases() as $category) {
            $ticketsByCategory[$category->value] = Ticket::query()->where('category', $category->value)->count();
        }
        $totalTickets = Ticket::query()->count();
        return $this->response(['status' => ResponseHelper::RESPONSE_STATUS_OK, 'result' => [
            'total_tickets' => $totalTickets,
            'tickets_by_status' => $ticketsByStatus,
            'tickets_by_category' => $ticketsByCategory
        ]]);

    }
}
