<?php

declare(strict_types=1);

namespace App\Music\Domain\Service;

class UploadMusicService
{
    private AuthorService $authorService;

    private AlbumService $albumService;

    private SongService $songService;

    private MusicDiscoveryInterface $musicDiscovery;

    private StorageServiceInterface $storageService;

    public function __construct(
        AuthorService $authorService,
        AlbumService $albumService,
        SongService $songService,
        MusicDiscoveryInterface $musicDiscovery,
        StorageServiceInterface $storageService,
    ) {
        $this->authorService = $authorService;
        $this->albumService = $albumService;
        $this->songService = $songService;
        $this->musicDiscovery = $musicDiscovery;
        $this->storageService = $storageService;
    }

    public function uploadMusic(string $filename, string $originalFilename): void
    {
        $audioMetadata = $this->musicDiscovery->getMetadata($filename);
        $author = $this->authorService->createAuthorFromAudioMetadata($audioMetadata);
        $album = $this->albumService->createAlbumFromAudioMetadata($audioMetadata, $author);
        $song = $this->songService->createSongFromAudioMetadata($audioMetadata, $album, $originalFilename);

        if ($song->getFilename() === $filename) {
            $this->storageService->storeMusicFile($filename);
        }
        $this->storageService->removeUploadedFile($filename);
    }
}
