<?php

declare(strict_types=1);

namespace App\Music\Application\Message;

use App\Common\Domain\Bus\Cloud\CloudMessageInterface;

class UploadMusicMessage implements CloudMessageInterface
{
    private string $importId;

    private string $filename;

    private string $originalFilename;

    public function __construct(string $importId, string $filename, string $originalFilename)
    {
        $this->importId = $importId;
        $this->filename = $filename;
        $this->originalFilename = $originalFilename;
    }

    public function getImportId(): string
    {
        return $this->importId;
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
