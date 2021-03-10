<?php

declare(strict_types=1);

namespace App\Music\Domain\Service;

use App\Music\Domain\Dto\AudioMetadataDTO;
use App\Music\Domain\Entity\Author;
use App\Music\Domain\Repository\AuthorRepositoryInterface;
use Symfony\Component\Uid\Uuid;

class AuthorService
{
    private AuthorRepositoryInterface $repository;

    public function __construct(AuthorRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function createAuthorFromAudioMetadata(AudioMetadataDTO $audioMetadataDTO): Author
    {
        $author = $this->repository->findAuthorByName($audioMetadataDTO->getAuthor());

        if (null === $author) {
            $author = new Author(
                Uuid::v4(),
                $audioMetadataDTO->getAuthor(),
                new \DateTime()
            );
            $this->repository->save($author);
        }

        return $author;
    }

    public function findAuthorById(Uuid $authorId): ?Author
    {
        return $this->repository->findAuthorById($authorId);
    }

    public function findAllAuthors(): array
    {
        return $this->repository->findAllAuthors();
    }
}
