<?php

declare(strict_types=1);

namespace App\BasicExample\Ui\Action;

use App\BasicExample\Application\Command\CreateMotorcycleCommand;
use App\BasicExample\Ui\Action\Request\CreateMotorcycleRequest;
use App\Common\Domain\Bus\Cloud\CloudBusInterface;
use App\Common\Domain\Bus\Command\CommandBusInterface;
use App\Common\Domain\Bus\Query\QueryBusInterface;
use App\Common\Ui\Action\AbstractActionController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

class CreateMotorcycleAction extends AbstractActionController
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

    public function __invoke(Request $request): Response
    {
        $bulk = $this->serializer->deserialize(
            $request->getContent(),
            CreateMotorcycleRequest::class.'[]',
            JsonEncoder::FORMAT
        );

        foreach ($bulk as $item) {
            $command = CreateMotorcycleCommand::createFromRequest($item);
            $this->execute($command);
        }

        return new Response('', Response::HTTP_CREATED);
    }
}
