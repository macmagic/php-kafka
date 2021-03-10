<?php


namespace App\Music\Ui\Action\Response;


use App\Common\Domain\Bus\Query\ResponseInterface;

class AuthorsResponse implements ResponseInterface
{
    /** @var AuthorResponse[] */
    private array $authors;

    public function __construct(array $authors)
    {
        $this->authors = $authors;
    }

    public function getAuthors(): array
    {
        return $this->authors;
    }
}