<?php

declare(strict_types=1);

namespace App\Music\Ui\Converter;

use App\Music\Domain\Entity\Song;
use App\Music\Ui\Action\Response\SongResponse;

class SongResponseConverter
{
    public static function convert(Song $song): SongResponse
    {
        return new SongResponse(
            $song->getId()->jsonSerialize(),
            $song->getTitle(),
            $song->getAlbum()->getAuthor()->getName(),
            $song->getAlbum()->getName(),
            $song->getAlbum()->getYear(),
            $song->getDuration(),
            $song->getTrackNumber(),
            $song->getQuality(),
            $song->getFilename(),
            $song->getOriginalFilename()
        );
    }
}
