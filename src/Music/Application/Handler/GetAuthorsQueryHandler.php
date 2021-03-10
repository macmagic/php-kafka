<?php

declare(strict_types=1);

namespace App\Music\Application\Handler;

use App\Common\Domain\Bus\Query\QueryHandlerInterface;
use App\Common\Domain\Bus\Query\ResponseInterface;
use App\Music\Application\Query\GetAuthorsQuery;
use App\Music\Domain\Service\AuthorService;
use App\Music\Ui\Converter\AuthorsResponseConverter;

class GetAuthorsQueryHandler implements QueryHandlerInterface
{
    private AuthorService $authorService;

    public function __construct(AuthorService $authorService)
    {
        $this->authorService = $authorService;
    }

    public function __invoke(GetAuthorsQuery $query): ResponseInterface
    {
        $authors = $this->authorService->findAllAuthors();

        return AuthorsResponseConverter::convert($authors);
    }
}
