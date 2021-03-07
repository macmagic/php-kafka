<?php

declare(strict_types=1);

namespace App\Music\Infrastructure\Persistence\Repository;

use App\Music\Domain\Entity\Album;
use App\Music\Domain\Entity\Author;
use App\Music\Domain\Repository\AlbumRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Album|null findOneBy(array $criteria, ?array $orderBy = null)
 */
class AlbumDoctrineRepositoryInterface extends ServiceEntityRepository implements AlbumRepositoryInterface
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
