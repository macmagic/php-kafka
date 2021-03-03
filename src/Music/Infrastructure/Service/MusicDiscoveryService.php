<?php

declare(strict_types=1);

namespace App\Music\Infrastructure\Service;

use App\Music\Domain\Dto\AudioMetadataDTO;
use App\Music\Domain\Service\MusicDiscoveryInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class MusicDiscoveryService implements MusicDiscoveryInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;

    private ParameterBagInterface $parameterBag;

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
        $audioMetadata->setAuthor($metadata['comments_html']['band'][0]);
        $audioMetadata->setAlbum($metadata['comments_html']['album'][0]);
        $audioMetadata->setYear((int) ($metadata['comments_html']['year'][0]));
        $audioMetadata->setTrackNumber(isset($metadata['comments_html']['track_number']) ? (int) ($metadata['comments_html']['track_number'][0]) : '');
        $audioMetadata->setQuality((string) ($metadata['bitrate'] / 1000).'kbps');
        $audioMetadata->setDuration($metadata['playtime_string']);
        $audioMetadata->setFileSize(filesize($filePath));

        return $audioMetadata;
    }
}
