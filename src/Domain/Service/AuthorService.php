<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\Domain\dto\AudioMetadataDTO;
use App\Domain\Entity\Author;
use App\Domain\Repository\AuthorRepository;
use Symfony\Component\Uid\Uuid;

class AuthorService
{
    private AuthorRepository $repository;

    public function __construct(AuthorRepository $repository)
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
}
