<?php


namespace App\BasicExample\Infrastructure\HttpClient;


use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class KafkaHttpClient
{
    private HttpClientInterface $client;

    private SerializerInterface $serializer;

    public function __construct(HttpClientInterface $client, SerializerInterface $serializer)
    {
        $this->client = $client;
        $this->serializer = $serializer;
    }

    public function sendKafkaMessage(): void
    {
        $this->client->request(
            'POST',
            'http://php.kafka.rest-proxy.:8082/topics/rest',
            [
                'headers' => [
                    'Content-Type' => 'application/vnd.kafka.binary.v2+json',
                ],
                'json' => [
                    'records' => [
                        ['value' => 'Hello'],
                    ],
                ],
            ]
        );
    }

    public function getKafkaMessage(): string
    {
        $response = $this->client->request(
            'GET',
            'http://php.kafka.rest-proxy.:8082/topics/rest/partitions/0',
        );

        echo $response->getContent();
        exit;
    }
}