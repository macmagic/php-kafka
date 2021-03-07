<?php

declare(strict_types=1);

namespace App\BasicExample\Infrastructure\Cloud;

use App\BasicExample\Domain\Cloud\CloudServiceInterface;
use Enqueue\RdKafka\RdKafkaConnectionFactory;
use Enqueue\RdKafka\RdKafkaContext;
use Interop\Queue\Exception;
use Interop\Queue\Exception\InvalidDestinationException;
use Interop\Queue\Exception\InvalidMessageException;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;

class KafkaService implements CloudServiceInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;

    private RdKafkaContext $context;

    public function __construct()
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

        $this->context = $connectionFactory->createContext();
    }

    public function sendMessage(string $message, string $topic): void
    {
        try {
            $topicConfig = $this->context->createTopic($topic);
            $message = $this->context->createMessage($message);

            $this->context->createProducer()->send($topicConfig, $message);
        } catch (InvalidDestinationException $e) {
            $this->logger->error(sprintf('Invalid destination error: %s', $e->getMessage()));
        } catch (InvalidMessageException $e) {
            $this->logger->error(sprintf('Invalid message error: %s', $e->getMessage()));
        } catch (Exception $e) {
            $this->logger->error(sprintf('Error when try to send the message: %s', $e->getMessage()));
        }
    }

    public function getMessage(string $topic): array
    {
        $topicConfig = $this->context->createQueue($topic);
        $consumer = $this->context->createConsumer($topicConfig);
        $consumer->setCommitAsync(true);

        $messagesCollection = [];

        while (true) {
            $message = $consumer->receive(2000);

            if (null === $message) {
                break;
            }

            $messagesCollection[] = $message->getBody();
            $consumer->acknowledge($message);
        }

        return $messagesCollection;
    }
}
