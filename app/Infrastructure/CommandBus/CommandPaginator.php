<?php

namespace App\Infrastructure\CommandBus;


trait CommandPaginator
{
    /**
     * @var bool
     */
    private bool $paginate = false;
    /**
     * @var int
     */
    private int $perPage = 10;

    /**
     * @return bool
     */
    public function isPaginate(): bool
    {
        return $this->paginate;
    }

    /**
     * @return int
     */
    public function getPerPage(): int
    {
        return $this->perPage;
    }

    /**
     * @param int $perPage
     * @return Command
     */
    public function allowPaginate(int $perPage = 10): Command
    {
        $this->paginate = true;
        $this->perPage = $perPage;
        return $this;
    }
}
