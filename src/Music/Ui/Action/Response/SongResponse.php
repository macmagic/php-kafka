<?php

declare(strict_types=1);

namespace App\Music\Ui\Action\Response;

use App\Common\Domain\Bus\Query\ResponseInterface;

class SongResponse implements ResponseInterface
{
    private string $id;

    private string $title;

    private string $author;

    private string $album;

    private int $year;

    private string $duration;

    private int $trackNumber;

    private string $quality;

    private string $filename;

    private string $originalFilename;

    public function __construct(
        string $id,
        string $title,
        string $author,
        string $album,
        int $year,
        string $duration,
        int $trackNumber,
        string $quality,
        string $filename,
        string $originalFilename)
    {
        $this->id = $id;
        $this->title = $title;
        $this->author = $author;
        $this->album = $album;
        $this->year = $year;
        $this->duration = $duration;
        $this->trackNumber = $trackNumber;
        $this->quality = $quality;
        $this->filename = $filename;
        $this->originalFilename = $originalFilename;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function getAlbum(): string
    {
        return $this->album;
    }

    public function getYear(): int
    {
        return $this->year;
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
}
