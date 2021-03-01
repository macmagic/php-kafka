<?php

declare(strict_types=1);

namespace App\Application\Handler;

use App\Application\Exception\DataNotFoundException;
use App\Application\Query\GetSongQuery;
use App\Application\Response\SongResponse;
use App\Domain\Bus\Query\QueryHandlerInterface;
use App\Domain\Service\SongService;

class GetSongQueryHandler implements QueryHandlerInterface
{
    private SongService $songService;

    public function __construct(SongService $songService)
    {
        $this->songService = $songService;
    }

    public function __invoke(GetSongQuery $query): SongResponse
    {
        $song = $this->songService->findSongById($query->getSongId());

        if (null === $song) {
            throw new DataNotFoundException(sprintf('Cannot find song by id %s', $query->getSongId()));
        }

        return new SongResponse(
            $song->getId()->jsonSerialize(),
            $song->getTitle(),
            $song->getDuration(),
            $song->getTrackNumber(),
            $song->getQuality(),
            $song->getFilename(),
            $song->getOriginalFilename()
        );
    }
}
