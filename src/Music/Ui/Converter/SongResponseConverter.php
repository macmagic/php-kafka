<?php

declare(strict_types=1);

namespace App\Music\Ui\Converter;

use App\Music\Domain\Entity\Song;
use App\Music\Ui\Action\Response\SongResponse;

class SongResponseConverter
{
    private const PLAY_SONG_URL = "/api/v1/music/song/%s/play";

    public static function convert(Song $song): SongResponse
    {
        return new SongResponse(
            $song->getId()->jsonSerialize(),
            $song->getTitle(),
            $song->getAlbum()->getId()->jsonSerialize(),
            $song->getDuration(),
            $song->getTrackNumber(),
            $song->getQuality(),
            $song->getFilename(),
            $song->getOriginalFilename(),
            sprintf(self::PLAY_SONG_URL, $song->getId()->jsonSerialize())
        );
    }
}
