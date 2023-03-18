<?php

namespace App\Dto\Request\Collage;

class CollageSearchRequestDto
{
    private string $query;

    public function getQuery(): string
    {
        return $this->query;
    }

    public function setQuery(string $query): void
    {
        $this->query = $query;
    }
}
