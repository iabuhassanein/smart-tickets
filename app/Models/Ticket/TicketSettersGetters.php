<?php

namespace App\Models\Ticket;

use Illuminate\Support\Carbon;

/**
 *
 */
trait TicketSettersGetters
{
    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     * @return void
     */
    public function setSubject(string $subject): void
    {
        $this->subject = $subject;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @param string $body
     * @return void
     */
    public function setBody(string $body): void
    {
        $this->body = $body;
    }

    /**
     * @return TicketStatus
     */
    public function getStatus(): TicketStatus
    {
        return $this->status;
    }

    /**
     * @param TicketStatus $status
     * @return void
     */
    public function setStatus(TicketStatus $status): void
    {
        $this->status = $status;
    }

    /**
     * @return ?TicketCategory|null
     */
    public function getCategory(): ?TicketCategory
    {
        return $this->category;
    }

    /**
     * @param TicketCategory|null $category
     * @return void
     */
    public function setCategory(?TicketCategory $category): void
    {
        $this->category = $category;
    }

    /**
     * @return float
     */
    public function getConfidence(): float
    {
        return $this->confidence;
    }

    /**
     * @param float $confidence
     * @return void
     */
    public function setConfidence(float $confidence): void
    {
        $this->confidence = $confidence;
    }

    /**
     * @return string
     */
    public function getExplanation(): string
    {
        return $this->explanation;
    }

    /**
     * @param string $explanation
     * @return void
     */
    public function setExplanation(string $explanation): void
    {
        $this->explanation = $explanation;
    }

    /**
     * @return ?string|null
     */
    public function getNote(): ?string
    {
        return $this->note;
    }

    /**
     * @param string|null $note
     * @return void
     */
    public function setNote(?string $note): void
    {
        $this->note = $note;
    }


    /**
     * @return bool
     */
    public function isOverride(): bool
    {
        return $this->isOverride;
    }

    /**
     * @param bool $isOverride
     * @return void
     */
    public function setIsOverride(bool $isOverride): void
    {
        $this->isOverride = $isOverride;
    }

    /**
     * @return Carbon
     */
    public function getCreatedAt(): Carbon
    {
        return $this->created_at;
    }

    /**
     * @return Carbon
     */
    public function getUpdatedAt(): Carbon
    {
        return $this->updated_at;
    }
}
