<?php

declare(strict_types=1);

namespace App\Music\Infrastructure\Persistence\Repository;

use App\Music\Domain\Entity\Author;
use App\Music\Domain\Repository\AuthorRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

/**
 * @method Author|null findOneBy(array $criteria, ?array $orderBy = null)
 */
class AuthorDoctrineRepositoryInterface extends ServiceEntityRepository implements AuthorRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Author::class);
    }

    public function findAuthorByName(string $authorName): ?Author
    {
        return $this->findOneBy(['name' => $authorName]);
    }

    public function findAuthorById(Uuid $authorId): ?Author
    {
        return $this->findOneBy(['id' => $authorId]);
    }

    public function findAllAuthors(): array
    {
        return $this->findAll();
    }

    public function save(Author $author): void
    {
        $this->getEntityManager()->persist($author);
        $this->getEntityManager()->flush();
    }
}
