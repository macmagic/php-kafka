<?php


namespace App\Music\Ui\Converter;


use App\Music\Domain\Entity\Author;
use App\Music\Ui\Action\Response\AuthorsResponse;

class AuthorsResponseConverter
{
    public static function convert(array $authors): AuthorsResponse
    {
        $authorsResponse = [];

        /** @var Author $author */
        foreach ($authors as $author) {
            $authorsResponse[] = AuthorResponseConverter::convert($author);
        }

        return new AuthorsResponse($authorsResponse);
    }
}