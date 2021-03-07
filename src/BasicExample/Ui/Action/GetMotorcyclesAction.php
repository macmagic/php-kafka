<?php

declare(strict_types=1);

namespace App\BasicExample\Ui\Action;

use App\BasicExample\Application\Query\GetMotorcyclesQuery;
use App\Common\Domain\Bus\Cloud\CloudBusInterface;
use App\Common\Domain\Bus\Command\CommandBusInterface;
use App\Common\Domain\Bus\Query\QueryBusInterface;
use App\Common\Ui\Action\AbstractActionController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

class GetMotorcyclesAction extends AbstractActionController
{
    private SerializerInterface $serializer;

    public function __construct(
        CloudBusInterface $cloudBus,
        CommandBusInterface $commandBus,
        QueryBusInterface $queryBus,
        SerializerInterface $serializer
    ) {
        parent::__construct($cloudBus, $commandBus, $queryBus);
        $this->serializer = $serializer;
    }

    public function __invoke(): Response
    {
        $query = new GetMotorcyclesQuery();
        $result = $this->ask($query);

        return JsonResponse::fromJsonString(
            $this->serializer->serialize($result, JsonEncoder::FORMAT)
        );
    }
}
