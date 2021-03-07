<?php

declare(strict_types=1);

namespace App\BasicExample\Ui\Converter;

use App\BasicExample\Ui\Action\Response\MotorcyclesResponse;

class MotorcyclesResponseConverter
{
    public static function convertFromJsonArray(array $messages): MotorcyclesResponse
    {
        $responseData = [];
        foreach ($messages as $message) {
            $responseData[] = MotorcycleResponseConverter::convertFromJson($message);
        }

        return new MotorcyclesResponse($responseData);
    }
}
