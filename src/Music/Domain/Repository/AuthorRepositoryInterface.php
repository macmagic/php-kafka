<?php

declare(strict_types=1);

namespace App\Music\Domain\Repository;

use App\Music\Domain\Entity\Author;

interface AuthorRepositoryInterface
{
    public function findAuthorByName(string $authorName): ?Author;

    public function save(Author $author): void;
}
