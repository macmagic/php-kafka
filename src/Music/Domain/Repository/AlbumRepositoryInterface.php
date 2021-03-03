<?php

declare(strict_types=1);

namespace App\Music\Domain\Repository;

use App\Music\Domain\Entity\Album;
use App\Music\Domain\Entity\Author;

interface AlbumRepositoryInterface
{
    public function findAlbumByNameAndAuthor(string $albumName, Author $author): ?Album;

    public function save(Album $album): void;
}
