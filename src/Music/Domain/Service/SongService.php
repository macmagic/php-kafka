<?php

declare(strict_types=1);

namespace App\Music\Domain\Service;

use App\Music\Domain\Dto\AudioMetadataDTO;
use App\Music\Domain\Entity\Album;
use App\Music\Domain\Entity\Song;
use App\Music\Domain\Repository\SongRepositoryInterface;
use Symfony\Component\Uid\Uuid;

class SongService
{
    private SongRepositoryInterface $repository;

    public function __construct(SongRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function createSongFromAudioMetadata(AudioMetadataDTO $audioMetadataDTO, Album $album, string $originalFilename): Song
    {
        $song = $this->repository->findSongByTitleAndAlbum($audioMetadataDTO->getTitle(), $album);

        if (null === $song) {
            $song = new Song(
                Uuid::v4(),
                $audioMetadataDTO->getFilename(),
                $originalFilename,
                $audioMetadataDTO->getFileSize(),
                $audioMetadataDTO->getTitle(),
                $audioMetadataDTO->getDuration(),
                $audioMetadataDTO->getTrackNumber(),
                $audioMetadataDTO->getQuality(),
                new \DateTime(),
                $album
            );
        }

        $this->repository->save($song);

        return $song;
    }

    public function findSongById(Uuid $songId): ?Song
    {
        return $this->repository->findById($songId);
    }
}
