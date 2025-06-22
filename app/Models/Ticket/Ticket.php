<?php

namespace App\Models\Ticket;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;

/**
 * @property string $id
 * @property string $subject
 * @property string $body
 * @property TicketStatus $status
 * @property TicketCategory $category
 * @property float $confidence
 * @property string $explanation
 * @property string $note
 * @property bool $isOverride
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Ticket extends Model
{
    use HasUlids, HasFactory, TicketSettersGetters;

    protected $table = 'tickets';

    protected $attributes = [
        'id' => '',
        'subject' => '',
        'body' => '',
        'status' => TicketStatus::NEW->value,
        'category' => null,
        'confidence' => 0,
        'explanation' => '',
        'isOverride' => false,
    ];

    protected $fillable = [
        'subject',
        'body',
        'status',
        'category',
        'confidence',
        'explanation',
        'note',
        'isOverride',
    ];

    // Cast enum fields
    protected $casts = [
        'status' => TicketStatus::class,
        'category' => TicketCategory::class,
    ];

    // Scope methods for filtering
    public function scopeByStatus($query, string $status)
    {
        dd($status);
        return $query->where('status', $status);
    }

    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    public function scopeFilters($query, array $filters)
    {
        if (key_exists('status', $filters) && !empty($filters['status']))
            $query = $query->where('status', trim($filters['status']));

        if (key_exists('category', $filters) && !empty($filters['category']))
            $query = $query->where('category', trim($filters['category']));

        return $query;
    }

    public function scopeSearch($query, string $search)
    {
        if ($search)
            return $query->where('subject', 'LIKE',  '%' . trim($search) .'%');
        else
            return $query;
    }

    public function scopeOpen($query)
    {
        return $query->where('status', TicketStatus::NEW)
            ->orWhere('status', TicketStatus::IN_PROGRESS);
    }
}
