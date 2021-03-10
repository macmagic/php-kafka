<?php


namespace App\Music\Ui\Action\Response;


use App\Common\Domain\Bus\Query\ResponseInterface;

class AuthorResponse implements ResponseInterface
{
    private string $authorId;

    private string $name;

    private array $albumUrls;

    public function __construct(string $authorId, string $name, array $albumUrls)
    {
        $this->authorId = $authorId;
        $this->name = $name;
        $this->albumUrls = $albumUrls;
    }

    public function getAuthorId(): string
    {
        return $this->authorId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAlbumUrls(): array
    {
        return $this->albumUrls;
    }
}