<?php

declare(strict_types=1);

namespace App\Music\Ui\Action\Response;

use App\Common\Domain\Bus\Query\ResponseInterface;

class PlaySongResponse implements ResponseInterface
{
    private string $songFilename;

    public function __construct(string $songFilename)
    {
        $this->songFilename = $songFilename;
    }

    public function getSongFilename(): string
    {
        return $this->songFilename;
    }
}
