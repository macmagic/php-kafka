<?php

declare(strict_types=1);

namespace App\Music\Ui\Action;

use App\Common\Ui\Action\AbstractActionController;
use App\Music\Application\Query\GetAlbumCoverImageQuery;
use App\Music\Ui\Action\Response\CoverResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;

class GetAlbumCoverImageAction extends AbstractActionController
{
    public function __invoke(string $coverId): Response
    {
        $query = new GetAlbumCoverImageQuery($coverId);

        /** @var CoverResponse $result */
        $result = $this->ask($query);

        return new BinaryFileResponse($result->getFilename());
    }
}
