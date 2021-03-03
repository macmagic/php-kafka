<?php

declare(strict_types=1);

namespace App\Ui\Action;

use App\Application\Query\GetSongQuery;
use App\Common\Domain\Bus\Query\QueryBusInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Uid\Uuid;

class GetSongAction
{
    private QueryBusInterface $queryBus;

    private SerializerInterface $serializer;

    public function __construct(QueryBusInterface $queryBus, SerializerInterface $serializer)
    {
        $this->queryBus = $queryBus;
        $this->serializer = $serializer;
    }

    public function __invoke(string $id): Response
    {
        $query = new GetSongQuery(Uuid::fromString($id));
        $result = $this->queryBus->ask($query);

        return JsonResponse::fromJsonString(
            $this->serializer->serialize(
                $result,
                JsonEncoder::FORMAT
            )
        );
    }
}
