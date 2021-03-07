<?php

declare(strict_types=1);

namespace App\Music\Domain\Service;

interface StorageServiceInterface
{
    public function removeUploadedFile(string $filename);

    public function storeMusicFile(string $filename): void;

    public function getMusicFile(string $filename): ?string;

    public function saveAlbumCoverFile(string $coverContent): string;

    public function getAlbumCoverFile(string $filename): ?string;
}
