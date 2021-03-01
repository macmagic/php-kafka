<?php

declare(strict_types=1);

namespace App\Infrastructure\Service;

use App\Domain\dto\AudioMetadataDTO;
use App\Domain\Service\MusicDiscoveryInterface;

class MusicDiscoveryService implements MusicDiscoveryInterface
{
    public function getMetadata(string $filename, string $uploadDir): AudioMetadataDTO
    {
        $filePath = $uploadDir.'/'.$filename;
        $getID3 = new \getID3();
        $metadata = $getID3->analyze($filePath);
        $getID3->CopyTagsToComments($metadata);

        $audioMetadata = new AudioMetadataDTO();
        $audioMetadata->setFilename($filename);
        $audioMetadata->setTitle($metadata['comments_html']['title'][0]);
        $audioMetadata->setAuthor($metadata['comments_html']['band'][0]);
        $audioMetadata->setAlbum($metadata['comments_html']['album'][0]);
        $audioMetadata->setYear($metadata['comments_html']['year'][0]);
        $audioMetadata->setTrackNumber(isset($metadata['comments_html']['track_number']) ? $metadata['comments_html']['track_number'][0] : '');
        $audioMetadata->setQuality((string) ($metadata['bitrate'] / 1000).'kbps');
        $audioMetadata->setDuration($metadata['playtime_string']);
        $audioMetadata->setFileSize(filesize($filePath));

        return $audioMetadata;
    }
}
