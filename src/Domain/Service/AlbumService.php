<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\Domain\dto\AudioMetadataDTO;
use App\Domain\Entity\Album;
use App\Domain\Entity\Author;
use App\Domain\Repository\AlbumRepository;
use Symfony\Component\Uid\Uuid;

class AlbumService
{
    private AlbumRepository $repository;

    public function __construct(AlbumRepository $repository)
    {
        $this->repository = $repository;
    }

    public function createAlbumFromAudioMetadata(AudioMetadataDTO $audioMetadataDTO, Author $author): Album
    {
        $album = $this->repository->findAlbumByNameAndAuthor($audioMetadataDTO->getAlbum(), $author);

        if (null === $album) {
            $album = new Album(
                Uuid::v4(),
                $audioMetadataDTO->getAlbum(),
                $audioMetadataDTO->getYear(),
                new \DateTime(),
                $author
            );

            $this->repository->save($album);
        }

        return $album;
    }
}
