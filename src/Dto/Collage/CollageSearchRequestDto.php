<?php

namespace App\Dto\Collage;

class CollageSearchRequestDto
{
    private string $search;

    public function getSearch(): string
    {
        return $this->search;
    }

    public function setSearch(string $search): void
    {
        $this->search = $search;
    }
}
