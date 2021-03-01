<?php

declare(strict_types=1);

namespace App\Ui\Action;

use App\Application\Command\CreateMotorcycleCommand;
use App\Domain\Bus\Command\CommandBusInterface;
use App\Infrastructure\HttpClient\KafkaHttpClient;
use App\Ui\Action\Request\CreateMotorcycleRequest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;

class CreateMotorcycleAction
{
    private CommandBusInterface $commandBus;

    private KafkaHttpClient $client;

    public function __construct(CommandBusInterface $commandBus, KafkaHttpClient $client)
    {
        $this->commandBus = $commandBus;
        $this->client = $client;
    }

    /**
     * @ParamConverter("request", converter="fos_rest.request_body")
     */
    public function __invoke(CreateMotorcycleRequest $request): Response
    {
        $command = CreateMotorcycleCommand::createFromRequest($request);
        $this->commandBus->execute($command);

        $this->client->sendKafkaMessage();

        return new Response('', Response::HTTP_CREATED);
    }
}
