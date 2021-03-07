<?php

declare(strict_types=1);

namespace App\Music\Ui\Action\Response;

use App\Common\Domain\Bus\Query\ResponseInterface;

class CoverResponse implements ResponseInterface
{
    private string $filename;

    public function __construct(string $filename)
    {
        $this->filename = $filename;
    }

    public function setFilename(string $filename): void
    {
        $this->filename = $filename;
    }

    public function getFilename(): string
    {
        return $this->filename;
    }
}
