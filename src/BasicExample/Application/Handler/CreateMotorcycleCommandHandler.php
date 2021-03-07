<?php

declare(strict_types=1);

namespace App\BasicExample\Application\Handler;

use App\BasicExample\Application\Command\CreateMotorcycleCommand;
use App\BasicExample\Domain\Cloud\CloudServiceInterface;
use App\Common\Domain\Bus\Command\CommandHandlerInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

class CreateMotorcycleCommandHandler implements CommandHandlerInterface
{
    private const TOPIC = 'motorcycle';

    private SerializerInterface $serializer;

    private CloudServiceInterface $cloudService;

    public function __construct(SerializerInterface $serializer, CloudServiceInterface $cloudService)
    {
        $this->serializer = $serializer;
        $this->cloudService = $cloudService;
    }

    public function __invoke(CreateMotorcycleCommand $command): void
    {
        $this->cloudService->sendMessage($this->serializer->serialize(
            $command,
            JsonEncoder::FORMAT
        ), self::TOPIC);
    }
}
