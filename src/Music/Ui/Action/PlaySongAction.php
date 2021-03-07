<?php

declare(strict_types=1);

namespace App\Music\Ui\Action;

use App\Common\Ui\Action\AbstractActionController;
use App\Music\Application\Query\PlaySongQuery;
use App\Music\Ui\Action\Response\PlaySongResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;

class PlaySongAction extends AbstractActionController
{
    public function __invoke(string $songId): Response
    {
        $query = new PlaySongQuery($songId);

        /** @var PlaySongResponse $result */
        $result = $this->ask($query);

        return new BinaryFileResponse($result->getSongFilename());
    }
}
