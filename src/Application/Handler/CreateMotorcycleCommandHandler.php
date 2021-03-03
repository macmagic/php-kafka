<?php

declare(strict_types=1);

namespace App\Application\Handler;

use App\Application\Command\CreateMotorcycleCommand;
use App\Common\Domain\Bus\Command\CommandHandlerInterface;
use Enqueue\RdKafka\RdKafkaConnectionFactory;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

class CreateMotorcycleCommandHandler implements CommandHandlerInterface
{
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function __invoke(CreateMotorcycleCommand $command): void
    {
        $connectionFactory = new RdKafkaConnectionFactory([
            'global' => [
                'group.id' => uniqid('', true),
                'metadata.broker.list' => 'php.kafka.broker:29092',
                'enable.auto.commit' => 'false',
            ],
            'topic' => [
                'auto.offset.reset' => 'beginning',
            ],
        ]);

        $context = $connectionFactory->createContext();

        $message = $context->createMessage($this->serializer->serialize($command, JsonEncoder::FORMAT));
        $topic = $context->createTopic('motorcycles');
        $context->createProducer()->send($topic, $message);
    }
}
