<?php

declare(strict_types=1);

namespace App\Music\Application\Query;

use App\Common\Domain\Bus\Query\QueryInterface;

class GetAuthorByIdQuery implements QueryInterface
{
    private string $authorId;

    public function __construct(string $authorId)
    {
        $this->authorId = $authorId;
    }

    public function getAuthorId(): string
    {
        return $this->authorId;
    }
}
