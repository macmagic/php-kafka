<?php

declare(strict_types=1);

namespace App\BasicExample\Application\Handler;

use App\BasicExample\Application\Query\GetMotorcyclesQuery;
use App\BasicExample\Domain\Cloud\CloudServiceInterface;
use App\BasicExample\Ui\Converter\MotorcyclesResponseConverter;
use App\Common\Domain\Bus\Query\QueryHandlerInterface;
use App\Common\Domain\Bus\Query\ResponseInterface;

class GetMotorcyclesQueryHandler implements QueryHandlerInterface
{
    private const TOPIC = 'motorcycle';

    private CloudServiceInterface $cloudService;

    public function __construct(CloudServiceInterface $cloudService)
    {
        $this->cloudService = $cloudService;
    }

    public function __invoke(GetMotorcyclesQuery $query): ?ResponseInterface
    {
        $messages = $this->cloudService->getMessage(self::TOPIC);

        return MotorcyclesResponseConverter::convertFromJsonArray($messages);
    }
}
