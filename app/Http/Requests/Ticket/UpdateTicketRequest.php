<?php

namespace App\Http\Requests\Ticket;

use App\Models\Ticket\TicketCategory;
use App\Models\Ticket\TicketStatus;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTicketRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'status' => 'nullable|string|in:' . TicketStatus::NEW->value . ',' . TicketStatus::IN_PROGRESS->value . ',' . TicketStatus::DONE->value,
            'note' => 'nullable|string',
            'category' => 'nullable|string|in:' . TicketCategory::TECHNICAL_SUPPORT->value . ',' . TicketCategory::BILLING_PAYMENT->value . ',' . TicketCategory::ACCOUNT_ACCESS->value . ',' . TicketCategory::BUG_REPORT->value . ',' . TicketCategory::FEATURE_REQUEST->value . ',' . TicketCategory::GENERAL_INQUIRY->value . ',' . TicketCategory::REFUND_REQUEST->value . ',' . TicketCategory::INSTALLATION_HELP->value . ',' . TicketCategory::PERFORMANCE_ISSUE->value . ',' . TicketCategory::SECURITY_CONCERN->value . ',' . TicketCategory::DATA_EXPORT->value . ',' . TicketCategory::INTEGRATION_SUPPORT->value
        ];
    }
}
