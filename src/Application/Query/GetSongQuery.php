<?php

declare(strict_types=1);

namespace App\Application\Query;

use App\Domain\Bus\Query\QueryInterface;
use Symfony\Component\Uid\Uuid;

class GetSongQuery implements QueryInterface
{
    private Uuid $songId;

    public function __construct(Uuid $songId)
    {
        $this->songId = $songId;
    }

    public function getSongId(): Uuid
    {
        return $this->songId;
    }
}
