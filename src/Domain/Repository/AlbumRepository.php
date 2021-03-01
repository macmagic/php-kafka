<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Album;
use App\Domain\Entity\Author;

interface AlbumRepository
{
    public function findAlbumByNameAndAuthor(string $albumName, Author $author): ?Album;

    public function save(Album $album): void;
}
