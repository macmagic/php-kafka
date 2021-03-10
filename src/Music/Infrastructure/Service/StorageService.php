<?php

declare(strict_types=1);

namespace App\Music\Infrastructure\Service;

use App\Music\Application\Exception\FileException;
use App\Music\Domain\Service\StorageServiceInterface;
use Symfony\Component\Uid\Uuid;

class StorageService implements StorageServiceInterface
{
    private string $uploadDir;

    private string $musicDir;

    private string $coverDir;

    public function __construct(string $uploadDir, string $musicDir, string $coverDir)
    {
        $this->uploadDir = $uploadDir;
        $this->musicDir = $musicDir;
        $this->coverDir = $coverDir;
    }

    public function removeUploadedFile(string $filename): void
    {
        $filePath = sprintf('%s/%s', $this->uploadDir, $filename);
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

    public function storeMusicFile(string $filename): void
    {
        $fileSource = sprintf('%s/%s', $this->uploadDir, $filename);
        $subDirPath = $this->getPathFromFilename($filename);
        $dirPath = sprintf('%s/%s', $this->musicDir, $subDirPath);

        if (!file_exists($dirPath)) {
            mkdir($dirPath, 0777, true);
        }

        $fileDestination = sprintf('%s/%s', $dirPath, $filename);

        if (!copy($fileSource, $fileDestination)) {
            throw new FileException('Cannot copy the file');
        }
    }

    public function getMusicFile(string $filename): ?string
    {
        $dirPath = sprintf('%s/%s', $this->musicDir, $this->getPathFromFilename($filename));
        $fullPath = sprintf('%s/%s', $dirPath, $filename);

        if (file_exists($fullPath)) {
            return $fullPath;
        }

        return null;
    }

    public function saveAlbumCoverFile(string $coverContent): string
    {
        $filename = Uuid::v4()->jsonSerialize().'.jpg';

        $dirPath = sprintf('%s/%s', $this->coverDir, $this->getPathFromFilename($filename));
        if (!file_exists($dirPath)) {
            mkdir($dirPath, 0777, true);
        }
        $fullPath = sprintf('%s/%s', $dirPath, $filename);
        file_put_contents($fullPath, $coverContent, \FILE_APPEND);

        return $filename;
    }

    public function getAlbumCoverFile(string $filename): ?string
    {
        $dirPath = sprintf('%s/%s', $this->coverDir, $this->getPathFromFilename($filename));
        $fullPath = sprintf('%s/%s', $dirPath, $filename);

        if (file_exists($fullPath)) {
            return $fullPath;
        }

        return null;
    }

    private function getPathFromFilename(string $filename): string
    {
        return mb_strtolower(mb_substr($filename, 0, 2));
    }
}
