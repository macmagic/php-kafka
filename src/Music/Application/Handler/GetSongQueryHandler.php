<?php

declare(strict_types=1);

namespace App\Music\Application\Handler;

use App\Common\Domain\Bus\Query\QueryHandlerInterface;
use App\Common\Domain\Bus\Query\ResponseInterface;
use App\Music\Application\Exception\SongNotFoundException;
use App\Music\Application\Query\GetSongQuery;
use App\Music\Domain\Service\SongService;
use App\Music\Ui\Converter\SongResponseConverter;
use Symfony\Component\Uid\Uuid;

class GetSongQueryHandler implements QueryHandlerInterface
{
    private SongService $songService;

    public function __construct(SongService $songService)
    {
        $this->songService = $songService;
    }

    public function __invoke(GetSongQuery $query): ?ResponseInterface
    {
        $song = $this->songService->findSongById(Uuid::fromString($query->getSongId()));

        if (null === $song) {
            throw new SongNotFoundException(sprintf('Cannot find the song by id %s', $query->getSongId()));
        }

        return SongResponseConverter::convert($song);
    }
}
