<?php

declare(strict_types=1);

namespace App\Domain\Service;

class ImportMusicService
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

    public function importMusic(string $filename, string $uploadDir, string $originalFilename)
    {
        $audioMetadata = $this->musicDiscovery->getMetadata($filename, $uploadDir);
        $author = $this->authorService->createAuthorFromAudioMetadata($audioMetadata);
        $album = $this->albumService->createAlbumFromAudioMetadata($audioMetadata, $author);
        $song = $this->songService->createSongFromAudioMetadata($audioMetadata, $album, $originalFilename);
    }
}
