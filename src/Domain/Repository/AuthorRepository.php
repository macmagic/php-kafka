<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Author;

interface AuthorRepository
{
    public function findAuthorByName(string $authorName): ?Author;

    public function save(Author $author): void;
}
