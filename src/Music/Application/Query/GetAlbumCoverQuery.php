<?php

declare(strict_types=1);

namespace App\Music\Application\Query;

use App\Common\Domain\Bus\Query\QueryInterface;

class GetAlbumCoverQuery implements QueryInterface
{
    private string $albumId;

    public function __construct(string $albumId)
    {
        $this->albumId = $albumId;
    }

    public function getAlbumId(): string
    {
        return $this->albumId;
    }
}
