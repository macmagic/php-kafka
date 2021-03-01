<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\Domain\dto\AudioMetadataDTO;

interface MusicDiscoveryInterface
{
    public function getMetadata(string $filename, string $uploadDir): AudioMetadataDTO;
}
