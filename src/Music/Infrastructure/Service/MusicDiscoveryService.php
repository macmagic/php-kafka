<?php

declare(strict_types=1);

namespace App\Music\Infrastructure\Service;

use App\Music\Domain\Dto\AudioMetadataDTO;
use App\Music\Domain\Service\MusicDiscoveryInterface;
use App\Music\Domain\Service\StorageServiceInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class MusicDiscoveryService implements MusicDiscoveryInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;

    private const NOT_FOUND_DEFAULT_VALUE = 'Unknown';

    private ParameterBagInterface $parameterBag;

    private StorageServiceInterface $storageServiceInterface;

    private string $uploadDir;

    public function __construct(ParameterBagInterface $parameterBag)
    {
        $this->parameterBag = $parameterBag;
        $this->uploadDir = $parameterBag->get('upload_dir');
    }

    public function getMetadata(string $filename): AudioMetadataDTO
    {
        $filePath = $this->uploadDir.'/'.$filename;
        $getID3 = new \getID3();
        $metadata = $getID3->analyze($filePath);
        $getID3->CopyTagsToComments($metadata);

        $audioMetadata = new AudioMetadataDTO();
        $audioMetadata->setFilename($filename);
        $this->logger->debug(print_r($metadata, true));
        $audioMetadata->setTitle($metadata['comments_html']['title'][0]);
        $audioMetadata->setAuthor($this->getAuthor($metadata));
        $audioMetadata->setAlbum($metadata['comments_html']['album'][0]);
        $audioMetadata->setYear(isset($metadata['comments_html']['year'][0]) ? (int) ($metadata['comments_html']['year'][0]) : 0);
        $audioMetadata->setTrackNumber(isset($metadata['comments_html']['track_number']) ? (int) ($metadata['comments_html']['track_number'][0]) : '');
        $audioMetadata->setQuality((string) ($metadata['bitrate'] / 1000).'kbps');
        $audioMetadata->setDuration($metadata['playtime_string']);
        $audioMetadata->setFileSize(filesize($filePath));
        $audioMetadata->setCoverImageContent($this->getCover($metadata));

        return $audioMetadata;
    }

    private function getAuthor(array $metadata): string
    {
        if (!empty($metadata['comments_html']['artist'][0])) {
            return $metadata['comments_html']['artist'][0];
        }
        if (!empty($metadata['comments_html']['band'][0])) {
            return $metadata['comments_html']['band'][0];
        }

        return self::NOT_FOUND_DEFAULT_VALUE;
    }

    private function getCover(array $metadata): ?string
    {
        if (isset($metadata['comments']['picture'][0])) {
            return $metadata['comments']['picture'][0]['data'];
        }

        return null;
    }
}
