<?php

declare(strict_types=1);

namespace App\Music\Ui\Action\Response;

use App\Common\Domain\Bus\Query\ResponseInterface;

class SongResponse implements ResponseInterface
{
    private string $id;

    private string $title;

    private string $albumId;

    private string $duration;

    private int $trackNumber;

    private string $quality;

    private string $filename;

    private string $originalFilename;

    private string $playSongUrl;

    public function __construct(
        string $id,
        string $title,
        string $albumId,
        string $duration,
        int $trackNumber,
        string $quality,
        string $filename,
        string $originalFilename,
        string $playSongUrl
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->albumId = $albumId;
        $this->duration = $duration;
        $this->trackNumber = $trackNumber;
        $this->quality = $quality;
        $this->filename = $filename;
        $this->originalFilename = $originalFilename;
        $this->playSongUrl = $playSongUrl;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getAlbumId(): string
    {
        return $this->albumId;
    }

    public function getDuration(): string
    {
        return $this->duration;
    }

    public function getTrackNumber(): int
    {
        return $this->trackNumber;
    }

    public function getQuality(): string
    {
        return $this->quality;
    }

    public function getFilename(): string
    {
        return $this->filename;
    }

    public function getOriginalFilename(): string
    {
        return $this->originalFilename;
    }

    public function getPlaySongUrl(): string
    {
        return $this->playSongUrl;
    }
}
