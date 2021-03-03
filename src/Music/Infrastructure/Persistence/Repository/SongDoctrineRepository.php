<?php

declare(strict_types=1);

namespace App\Music\Infrastructure\Persistence\Repository;

use App\Music\Domain\Entity\Album;
use App\Music\Domain\Entity\Song;
use App\Music\Domain\Repository\SongRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

/**
 * @method Song|null findOneBy(array $criteria, ?array $orderBy = null)
 */
class SongDoctrineRepository extends ServiceEntityRepository implements SongRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Song::class);
    }

    public function findSongByTitleAndAlbum(string $title, Album $album): ?Song
    {
        return $this->findOneBy([
            'title' => $title,
            'album' => $album,
        ]);
    }

    public function save(Song $song): void
    {
        $this->getEntityManager()->persist($song);
        $this->getEntityManager()->flush();
    }

    public function findById(Uuid $id): ?Song
    {
        return $this->findOneBy(['id' => $id]);
    }
}
