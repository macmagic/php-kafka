<?php

declare(strict_types=1);

namespace App\Music\Domain\Repository;

use App\Music\Domain\Entity\Album;
use App\Music\Domain\Entity\Author;
use Symfony\Component\Uid\Uuid;

interface AlbumRepositoryInterface
{
    public function findAlbumByNameAndAuthor(string $albumName, Author $author): ?Album;

    public function findAlbumById(Uuid $albumId): ?Album;

    public function save(Album $album): void;
}
