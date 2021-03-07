<?php

declare(strict_types=1);

namespace App\Music\Application\Query;

use App\Common\Domain\Bus\Query\QueryInterface;

class PlaySongQuery implements QueryInterface
{
    private string $songId;

    public function __construct(string $songId)
    {
        $this->songId = $songId;
    }

    public function getSongId(): string
    {
        return $this->songId;
    }
}
