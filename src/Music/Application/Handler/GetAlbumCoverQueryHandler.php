<?php

declare(strict_types=1);

namespace App\Music\Application\Handler;

use App\Common\Domain\Bus\Query\QueryHandlerInterface;
use App\Common\Domain\Bus\Query\ResponseInterface;
use App\Music\Application\Exception\AlbumNotFoundException;
use App\Music\Application\Exception\FileNotFoundException;
use App\Music\Application\Query\GetAlbumCoverQuery;
use App\Music\Domain\Service\AlbumService;
use App\Music\Domain\Service\StorageServiceInterface;
use App\Music\Ui\Action\Response\CoverResponse;
use Symfony\Component\Uid\Uuid;

class GetAlbumCoverQueryHandler implements QueryHandlerInterface
{
    private StorageServiceInterface $storageService;

    private AlbumService $albumService;

    public function __construct(StorageServiceInterface $storageService, AlbumService $albumService)
    {
        $this->storageService = $storageService;
        $this->albumService = $albumService;
    }

    public function __invoke(GetAlbumCoverQuery $query): ?ResponseInterface
    {
        $album = $this->albumService->getAlbumById(Uuid::fromString($query->getAlbumId()));

        if (null === $album) {
            throw new AlbumNotFoundException(sprintf("Cannot find album by id '%s'", $query->getAlbumId()));
        }

        $filename = $this->storageService->getAlbumCoverFile($album->getCoverFilename());

        if (null === $filename) {
            throw new FileNotFoundException(sprintf('Cannot find the filename: %s', $album->getCoverFilename()));
        }

        return new CoverResponse($filename);
    }
}
