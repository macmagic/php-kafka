<?php

declare(strict_types=1);

namespace App\Music\Ui\Action;

use App\Common\Ui\Action\AbstractActionController;
use App\Music\Application\Query\GetAlbumCoverQuery;
use App\Music\Ui\Action\Response\CoverResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;

class GetAlbumCoverByAlbumIdAction extends AbstractActionController
{
    public function __invoke(string $albumId): Response
    {
        $query = new GetAlbumCoverQuery($albumId);

        /** @var CoverResponse $result */
        $result = $this->ask($query);

        return new BinaryFileResponse($result->getFilename());
    }
}
