<?php

declare(strict_types=1);

namespace App\Music\Domain\Repository;

use App\Music\Domain\Entity\Album;
use App\Music\Domain\Entity\Song;
use Symfony\Component\Uid\Uuid;

interface SongRepositoryInterface
{
    public function findSongByTitleAndAlbum(string $title, Album $album): ?Song;

    public function save(Song $song): void;

    public function findById(Uuid $id): ?Song;
}
