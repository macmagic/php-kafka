<?php

declare(strict_types=1);

namespace App\Music\Application\Handler;

use App\Common\Domain\Bus\Query\QueryHandlerInterface;
use App\Common\Domain\Bus\Query\ResponseInterface;
use App\Music\Application\Query\GetAlbumCoverImageQuery;
use App\Music\Domain\Service\StorageServiceInterface;
use App\Music\Ui\Action\Response\CoverResponse;

class GetAlbumCoverImageQueryHandler implements QueryHandlerInterface
{
    private StorageServiceInterface $storageService;

    public function __construct(StorageServiceInterface $storageService)
    {
        $this->storageService = $storageService;
    }

    public function __invoke(GetAlbumCoverImageQuery $query): ?ResponseInterface
    {
        $filename = $this->storageService->getAlbumCoverFile($query->getCoverId());

        return new CoverResponse($filename);
    }
}
