<?php

declare(strict_types=1);

namespace App\Music\Ui\Action;

use App\Common\Domain\Bus\Cloud\CloudBusInterface;
use App\Common\Domain\Bus\Command\CommandBusInterface;
use App\Common\Domain\Bus\Query\QueryBusInterface;
use App\Common\Ui\Action\AbstractActionController;
use App\Music\Application\Query\GetSongQuery;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

class GetSongAction extends AbstractActionController
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

    public function __invoke(string $id): Response
    {
        $query = new GetSongQuery($id);
        $result = $this->ask($query);

        return JsonResponse::fromJsonString(
            $this->serializer->serialize(
                $result,
                JsonEncoder::FORMAT
            )
        );
    }
}
