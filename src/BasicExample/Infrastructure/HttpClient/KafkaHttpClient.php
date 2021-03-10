<?php

declare(strict_types=1);

namespace App\BasicExample\Infrastructure\HttpClient;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class KafkaHttpClient implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    private const CONSUMER_NAME = 'rest_proxy_consumer';

    private HttpClientInterface $client;

    private SerializerInterface $serializer;

    public function __construct(HttpClientInterface $client, SerializerInterface $serializer)
    {
        $this->client = $client;
        $this->serializer = $serializer;
    }

    public function produceMessage(string $topic, array $messages): ResponseInterface
    {
        $kafkaRecords = [];
        foreach ($messages as $item) {
            $kafkaRecords[] = ['value' => $item];
        }

        $bodyArray = ['records' => $kafkaRecords];

        $response = $this->client->request(
            'POST',
            'http://php.kafka.rest-proxy:8082/topics/rest',
            [
                'headers' => [
                    'Content-Type' => 'application/vnd.kafka.json.v2+json',
                ],
                'json' => $bodyArray,
            ]
        );

        return $response;
    }

    public function getKafkaMessage(): array
    {
        $response = $this->client->request(
            'POST',
            sprintf('http://php.kafka.rest-proxy:8082/consumers/%s', self::CONSUMER_NAME),
            [
                'headers' => [
                    'Content-Type' => 'application/vnd.kafka.json.v2+json',
                ],
                'json' => [
                    'name' => sprintf('%s_instance', self::CONSUMER_NAME),
                    'format' => 'json',
                    'auto.offset.reset' => 'earliest',
                    'auto.commit.enable' => 'false',
                ],
            ]
        );

        $body = json_decode($response->getContent(), true);
        $baseConsumerUri = $body['base_uri'];

        $response = $this->client->request(
            'POST',
            sprintf('%s/subscription', $baseConsumerUri),
            [
                'headers' => [
                    'Content-Type' => 'application/vnd.kafka.json.v2+json',
                ],
                'json' => [
                    'topics' => ['rest'],
                ],
            ]
        );

        $this->logger->info(sprintf('Request status from subscription is %d', $response->getStatusCode()));

        $response = $this->client->request(
            'GET',
            sprintf('%s/records', $baseConsumerUri),
            [
                'headers' => [
                    'Accept' => 'application/vnd.kafka.json.v2+json',
                ],
            ]
        );

        $responseContent = $response->getContent();

        $this->client->request(
            'DELETE',
            $baseConsumerUri,
            [
                'headers' => [
                    'Content-Type' => 'application/vnd.kafka.json.v2+json',
                ],
            ]
        );

        $records = json_decode($responseContent, true);
        $data = [];
        foreach ($records as $record) {
            $data[] = $record['value'];
        }

        return $data;
    }
}
