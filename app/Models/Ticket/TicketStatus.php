<?php

namespace App\Models\Ticket;

/**
 *
 */
enum TicketStatus: string
{
    case NEW = 'new';
    case IN_PROGRESS = 'in_progress';
    case DONE = 'done';

    /**
     * @return string
     */
    public function label(): string
    {
        return match($this) {
            self::NEW => 'New',
            self::IN_PROGRESS => 'In Progress',
            self::DONE => 'Done',
        };
    }
    /**
     * @return bool
     */
    public function isOpen(): bool
    {
        return match($this) {
            self::NEW, self::IN_PROGRESS => true,
            self::DONE => false,
        };
    }

    /**
     * @return bool
     */
    public function isClosed(): bool
    {
        return !$this->isOpen();
    }

    /**
     * @return TicketStatus[]
     */
    public static function getStatusKeysList(): array
    {
        return [
            self::NEW->value,
            self::IN_PROGRESS->value,
            self::DONE->value
        ];
    }

    /**
     * @param string $statusValue
     * @return TicketStatus
     */
    public static function getStatusEnum(string $statusValue): TicketStatus
    {
        return match($statusValue) {
            'new' => TicketStatus::NEW,
            'in_progress' => TicketStatus::IN_PROGRESS,
            'done' => TicketStatus::DONE
        };
    }
}
