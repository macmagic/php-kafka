<?php

declare(strict_types=1);

namespace App\Music\Domain\Service;

class UploadMusicService
{
    private AuthorService $authorService;

    private AlbumService $albumService;

    private SongService $songService;

    private MusicDiscoveryInterface $musicDiscovery;

    public function __construct(
        AuthorService $authorService,
        AlbumService $albumService,
        SongService $songService,
        MusicDiscoveryInterface $musicDiscovery
    ) {
        $this->authorService = $authorService;
        $this->albumService = $albumService;
        $this->songService = $songService;
        $this->musicDiscovery = $musicDiscovery;
    }

    public function importMusic(string $filename, string $originalFilename)
    {
        $audioMetadata = $this->musicDiscovery->getMetadata($filename);
        $author = $this->authorService->createAuthorFromAudioMetadata($audioMetadata);
        $album = $this->albumService->createAlbumFromAudioMetadata($audioMetadata, $author);
        $song = $this->songService->createSongFromAudioMetadata($audioMetadata, $album, $originalFilename);
    }
}
