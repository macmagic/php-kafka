<?php


namespace App\Music\Application\Handler;


use App\Common\Domain\Bus\Query\QueryHandlerInterface;
use App\Common\Domain\Bus\Query\ResponseInterface;
use App\Music\Application\Exception\AlbumNotFoundException;
use App\Music\Application\Query\GetAlbumQuery;
use App\Music\Domain\Service\AlbumService;
use App\Music\Ui\Converter\AlbumResponseConverter;
use Symfony\Component\Uid\Uuid;

class GetAlbumQueryHandler implements QueryHandlerInterface
{
    private AlbumService $albumService;

    public function __construct(AlbumService $albumService)
    {
        $this->albumService = $albumService;
    }

    public function __invoke(GetAlbumQuery $query): ?ResponseInterface
    {
        $album = $this->albumService->getAlbumById(Uuid::fromString($query->getAlbumId()));

        if (null === $album) {
            throw new AlbumNotFoundException(sprintf("Cannot find album by id: %s", $query->getAlbumId()));
        }

        return AlbumResponseConverter::convert($album);
    }
}