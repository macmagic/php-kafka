<?php

declare(strict_types=1);

namespace App\Domain\dto;

class AudioMetadataDTO
{
    private string $filename;

    private int $fileSize;

    private string $title;

    private string $author;

    private string $album;

    private string $duration;

    private string $trackNumber;

    private string $quality;

    private int $year;

    public function getFilename(): string
    {
        return $this->filename;
    }

    public function setFilename(string $filename): void
    {
        $this->filename = $filename;
    }

    public function getFileSize(): int
    {
        return $this->fileSize;
    }

    public function setFileSize(int $fileSize): void
    {
        $this->fileSize = $fileSize;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function setAuthor(string $author): void
    {
        $this->author = $author;
    }

    public function getAlbum(): string
    {
        return $this->album;
    }

    public function setAlbum(string $album): void
    {
        $this->album = $album;
    }

    public function getDuration(): string
    {
        return $this->duration;
    }

    public function setDuration(string $duration): void
    {
        $this->duration = $duration;
    }

    public function getTrackNumber(): string
    {
        return $this->trackNumber;
    }

    public function setTrackNumber(string $trackNumber): void
    {
        $this->trackNumber = $trackNumber;
    }

    public function getQuality(): string
    {
        return $this->quality;
    }

    public function setQuality(string $quality): void
    {
        $this->quality = $quality;
    }

    public function getYear(): int
    {
        return $this->year;
    }

    public function setYear(int $year): void
    {
        $this->year = $year;
    }
}
