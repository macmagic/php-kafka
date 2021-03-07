<?php

declare(strict_types=1);

namespace App\Music\Domain\Service;

use App\Music\Domain\Dto\AudioMetadataDTO;

interface MusicDiscoveryInterface
{
    public function getMetadata(string $filename): AudioMetadataDTO;
}
