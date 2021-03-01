<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Album;
use App\Domain\Entity\Song;
use Symfony\Component\Uid\Uuid;

interface SongRepository
{
    public function findSongByTitleAndAlbum(string $title, Album $album): ?Song;

    public function save(Song $song): void;

    public function findById(Uuid $id): ?Song;
}
