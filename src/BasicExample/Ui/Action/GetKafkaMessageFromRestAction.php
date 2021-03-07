<?php


namespace App\BasicExample\Ui\Action;


use App\BasicExample\Infrastructure\HttpClient\KafkaHttpClient;
use App\Common\Domain\Bus\Cloud\CloudBusInterface;
use App\Common\Domain\Bus\Command\CommandBusInterface;
use App\Common\Domain\Bus\Query\QueryBusInterface;
use App\Common\Ui\Action\AbstractActionController;

class GetKafkaMessageFromRestAction extends AbstractActionController
{
    private KafkaHttpClient $client;

    public function __construct(CloudBusInterface $cloudBus, CommandBusInterface $commandBus, QueryBusInterface $queryBus, KafkaHttpClient $client)
    {
        parent::__construct($cloudBus, $commandBus, $queryBus);
        $this->client = $client;
    }

    public function __invoke()
    {
        $this->client->getKafkaMessage();
    }
}