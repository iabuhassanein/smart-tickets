<?php

declare(strict_types=1);

namespace App\Application\Ticket\GetTickets;

use App\Infrastructure\CommandBus\Command;

class GetTickets implements Command
{
    /**
     * @var int
     */
    private int $page;
    /**
     * @var string
     */
    private string $search;
    /**
     * @var array
     */
    private array $filters;

    /**
     * @param int $page
     * @param string $search
     * @param array $filters
     */
    public function __construct(int $page, string $search, array $filters)
    {
        $this->setPage($page);
        $this->setSearch($search);
        $this->setFilters($filters);
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function setPage(int $page): void
    {
        $this->page = $page;
    }

    public function getSearch(): string
    {
        return $this->search;
    }

    public function setSearch(string $search): void
    {
        $this->search = $search;
    }

    public function getFilters(): array
    {
        return $this->filters;
    }

    public function setFilters(array $filters): void
    {
        $this->filters = $filters;
    }


}
