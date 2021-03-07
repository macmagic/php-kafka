<?php

declare(strict_types=1);

namespace App\Music\Application\Query;

use App\Common\Domain\Bus\Query\QueryInterface;

class GetAlbumCoverImageQuery implements QueryInterface
{
    private string $coverId;

    public function __construct(string $coverId)
    {
        $this->coverId = $coverId;
    }

    public function getCoverId(): string
    {
        return $this->coverId;
    }
}
