<?php


namespace App\Music\Ui\Converter;


use App\Music\Domain\Entity\Album;
use App\Music\Ui\Action\Response\AlbumResponse;

class AlbumResponseConverter
{
    private const COVER_URL = "/api/v1/music/album/%s/cover";

    public static function convert(Album $album): AlbumResponse
    {
        $songsResponse = [];

        foreach ($album->getSongs() as $song) {
            $songsResponse[] = SongResponseConverter::convert($song);
        }

        return new AlbumResponse(
            $album->getId()->jsonSerialize(),
            $album->getName(),
            $album->getYear(),
            sprintf(self::COVER_URL, $album->getId()->jsonSerialize()),
            $songsResponse
        );
    }
}