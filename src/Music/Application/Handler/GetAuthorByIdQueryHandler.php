<?php

declare(strict_types=1);

namespace App\Music\Application\Handler;

use App\Common\Domain\Bus\Query\QueryHandlerInterface;
use App\Common\Domain\Bus\Query\ResponseInterface;
use App\Music\Application\Exception\AuthorNotFoundException;
use App\Music\Application\Query\GetAuthorByIdQuery;
use App\Music\Domain\Service\AuthorService;
use App\Music\Ui\Converter\AuthorResponseConverter;
use Symfony\Component\Uid\Uuid;

class GetAuthorByIdQueryHandler implements QueryHandlerInterface
{
    private AuthorService $authorService;

    public function __construct(AuthorService $authorService)
    {
        $this->authorService = $authorService;
    }

    public function __invoke(GetAuthorByIdQuery $query): ResponseInterface
    {
        $author = $this->authorService->findAuthorById(Uuid::fromString($query->getAuthorId()));

        if (null === $author) {
            throw new AuthorNotFoundException(sprintf('Cannot find author by id: %s', $query->getAuthorId()));
        }

        return AuthorResponseConverter::convert($author);
    }
}
