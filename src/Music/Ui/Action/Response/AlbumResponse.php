<?php


namespace App\Music\Ui\Action\Response;


use App\Common\Domain\Bus\Query\ResponseInterface;

class AlbumResponse implements ResponseInterface
{
    private string $albumId;

    private string $name;

    private int $year;

    private string $coverUrl;

    /** @var SongResponse[] */
    private array $songs;

    public function __construct(string $albumId, string $name, int $year, string $coverUrl, array $songs)
    {
        $this->albumId = $albumId;
        $this->name = $name;
        $this->year = $year;
        $this->coverUrl = $coverUrl;
        $this->songs = $songs;
    }

    public function getAlbumId(): string
    {
        return $this->albumId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getYear(): int
    {
        return $this->year;
    }

    public function getCoverUrl(): string
    {
        return $this->coverUrl;
    }

    public function getSongs(): array
    {
        return $this->songs;
    }
}