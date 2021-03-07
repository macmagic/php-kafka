<?php

declare(strict_types=1);

namespace App\BasicExample\Ui\Converter;

use App\BasicExample\Ui\Action\Response\MotorcycleResponse;

class MotorcycleResponseConverter
{
    public static function convertFromJson(string $messageJson): MotorcycleResponse
    {
        $messageBodyArr = json_decode($messageJson, true);

        return new MotorcycleResponse(
            $messageBodyArr['brand'],
            $messageBodyArr['model'],
            $messageBodyArr['engineHp'],
            $messageBodyArr['year']
        );
    }
}
