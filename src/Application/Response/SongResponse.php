<?php

declare(strict_types=1);

namespace App\Application\Response;

use App\Domain\Bus\Query\ResponseInterface;

class SongResponse implements ResponseInterface
{
    private string $id;

    private string $title;

    private string $duration;

    private int $trackNumber;

    private string $quality;

    private string $filename;

    private string $originalFilename;

    public function __construct(string $id, string $title, string $duration, int $trackNumber, string $quality, string $filename, string $originalFilename)
    {
        $this->id = $id;
        $this->title = $title;
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
