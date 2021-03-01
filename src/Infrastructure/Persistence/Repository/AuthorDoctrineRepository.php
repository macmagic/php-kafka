<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Repository;

use App\Domain\Entity\Author;
use App\Domain\Repository\AuthorRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Author|null findOneBy(array $criteria, ?array $orderBy = null)
 */
class AuthorDoctrineRepository extends ServiceEntityRepository implements AuthorRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Author::class);
    }

    public function findAuthorByName(string $authorName): ?Author
    {
        return $this->findOneBy(['name' => $authorName]);
    }

    public function save(Author $author): void
    {
        $this->getEntityManager()->persist($author);
        $this->getEntityManager()->flush();
    }
}
