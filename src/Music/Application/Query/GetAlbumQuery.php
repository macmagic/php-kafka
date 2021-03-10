<?php


namespace App\Music\Application\Query;


use App\Common\Domain\Bus\Query\QueryInterface;

class GetAlbumQuery implements QueryInterface
{
    private string $albumId;

    public function __construct(string $albumId)
    {
        $this->albumId = $albumId;
    }

    public function getAlbumId(): string
    {
        return $this->albumId;
    }
}