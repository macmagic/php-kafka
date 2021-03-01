<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\Domain\dto\AudioMetadataDTO;
use App\Domain\Entity\Album;
use App\Domain\Entity\Song;
use App\Domain\Repository\SongRepository;
use Symfony\Component\Uid\Uuid;

class SongService
{
    private SongRepository $repository;

    public function __construct(SongRepository $repository)
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
