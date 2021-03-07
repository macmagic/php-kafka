<?php

declare(strict_types=1);

namespace App\Music\Application\Handler;

use App\Common\Domain\Bus\Query\QueryHandlerInterface;
use App\Common\Domain\Bus\Query\ResponseInterface;
use App\Music\Application\Exception\FileNotFoundException;
use App\Music\Application\Exception\SongNotFoundException;
use App\Music\Application\Query\PlaySongQuery;
use App\Music\Domain\Service\SongService;
use App\Music\Domain\Service\StorageServiceInterface;
use App\Music\Ui\Action\Response\PlaySongResponse;
use Symfony\Component\Uid\Uuid;

class PlaySongQueryHandler implements QueryHandlerInterface
{
    private SongService $songService;

    private StorageServiceInterface $storageService;

    public function __construct(SongService $songService, StorageServiceInterface $storageService)
    {
        $this->songService = $songService;
        $this->storageService = $storageService;
    }

    public function __invoke(PlaySongQuery $query): ResponseInterface
    {
        $song = $this->songService->findSongById(Uuid::fromString($query->getSongId()));

        if (null === $song) {
            throw new SongNotFoundException(sprintf('Cannot find the song by id %s', $query->getSongId()));
        }

        $fullPathFilename = $this->storageService->getMusicFile($song->getFilename());

        if (null === $fullPathFilename) {
            throw new FileNotFoundException(sprintf('Cannot find the file %s', $song->getFilename()));
        }

        return new PlaySongResponse($fullPathFilename);
    }
}
