<?php

declare(strict_types=1);

namespace App\Music\Domain\Service;

use App\Music\Domain\Dto\AudioMetadataDTO;
use App\Music\Domain\Entity\Album;
use App\Music\Domain\Entity\Author;
use App\Music\Domain\Repository\AlbumRepositoryInterface;
use Symfony\Component\Uid\Uuid;

class AlbumService
{
    private AlbumRepositoryInterface $repository;

    private StorageServiceInterface $storageService;

    public function __construct(AlbumRepositoryInterface $repository, StorageServiceInterface $storageService)
    {
        $this->repository = $repository;
        $this->storageService = $storageService;
    }

    public function createAlbumFromAudioMetadata(AudioMetadataDTO $audioMetadataDTO, Author $author): Album
    {
        $album = $this->repository->findAlbumByNameAndAuthor($audioMetadataDTO->getAlbum(), $author);

        if (null !== $album) {
            return $album;
        }

        $coverFilename = $this->storageService->saveAlbumCoverFile($audioMetadataDTO->getCoverImageContent());
        $album = new Album(
            Uuid::v4(),
            $audioMetadataDTO->getAlbum(),
            $audioMetadataDTO->getYear(),
            $coverFilename,
            new \DateTime(),
            $author
        );

        $this->repository->save($album);

        return $album;
    }
}
