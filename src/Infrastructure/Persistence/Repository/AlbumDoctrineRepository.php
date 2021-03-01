<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Repository;

use App\Domain\Entity\Album;
use App\Domain\Entity\Author;
use App\Domain\Repository\AlbumRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Album|null findOneBy(array $criteria, ?array $orderBy = null)
 */
class AlbumDoctrineRepository extends ServiceEntityRepository implements AlbumRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Album::class);
    }

    public function findAlbumByNameAndAuthor(string $albumName, Author $author): ?Album
    {
        return $this->findOneBy([
            'name' => $albumName,
            'author' => $author,
        ]);
    }

    public function save(Album $album): void
    {
        $this->getEntityManager()->persist($album);
        $this->getEntityManager()->flush();
    }
}
