<?php

declare(strict_types=1);

namespace App\Music\Domain\Repository;

use App\Music\Domain\Entity\Author;
use Symfony\Component\Uid\Uuid;

interface AuthorRepositoryInterface
{
    public function findAuthorByName(string $authorName): ?Author;

    public function findAuthorById(Uuid $authorId): ?Author;

    public function findAllAuthors(): array;

    public function save(Author $author): void;
}
