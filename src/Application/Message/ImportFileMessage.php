<?php

declare(strict_types=1);

namespace App\Application\Message;

use App\Domain\Bus\Cloud\CloudMessageInterface;

class ImportFileMessage implements CloudMessageInterface
{
    private string $importId;

    private string $uploadDir;

    private string $filename;

    private string $originalFilename;

    public function __construct(string $importId, string $uploadDir, string $filename, string $originalFilename)
    {
        $this->importId = $importId;
        $this->uploadDir = $uploadDir;
        $this->filename = $filename;
        $this->originalFilename = $originalFilename;
    }

    public function getImportId(): string
    {
        return $this->importId;
    }

    public function getUploadDir(): string
    {
        return $this->uploadDir;
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
