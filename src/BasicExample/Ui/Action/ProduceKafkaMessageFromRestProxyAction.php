<?php

declare(strict_types=1);

namespace App\BasicExample\Ui\Action;

use App\BasicExample\Infrastructure\HttpClient\KafkaHttpClient;
use App\Common\Domain\Bus\Cloud\CloudBusInterface;
use App\Common\Domain\Bus\Command\CommandBusInterface;
use App\Common\Domain\Bus\Query\QueryBusInterface;
use App\Common\Ui\Action\AbstractActionController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class ProduceKafkaMessageFromRestProxyAction extends AbstractActionController
{
    private KafkaHttpClient $client;

    private SerializerInterface $serializer;

    public function __construct(
        CloudBusInterface $cloudBus,
        CommandBusInterface $commandBus,
        QueryBusInterface $queryBus,
        KafkaHttpClient $client,
        SerializerInterface $serializer
    ) {
        parent::__construct($cloudBus, $commandBus, $queryBus);
        $this->client = $client;
        $this->serializer = $serializer;
    }

    public function __invoke(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
        $clientResponse = $this->client->produceMessage('rest-proxy', $data);

        return JsonResponse::fromJsonString($clientResponse->getContent(), $clientResponse->getStatusCode());
    }
}
