<?php

declare(strict_types=1);

namespace App\Music\Ui\Converter;

use App\Music\Domain\Entity\Album;
use App\Music\Domain\Entity\Author;
use App\Music\Ui\Action\Response\AuthorResponse;

class AuthorResponseConverter
{
    private const ALBUM_URL = '/api/v1/music/album/%s';

    public static function convert(Author $author): AuthorResponse
    {
        $albumUrls = [];

        /** @var Album $album */
        foreach ($author->getAlbums() as $album) {
            $albumUrls[] = sprintf(self::ALBUM_URL, $album->getId()->jsonSerialize());
        }

        return new AuthorResponse(
            $author->getId()->jsonSerialize(),
            $author->getName(),
            $albumUrls
        );
    }
}
