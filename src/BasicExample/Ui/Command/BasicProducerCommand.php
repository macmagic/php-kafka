<?php

declare(strict_types=1);

namespace App\BasicExample\Ui\Command;

use RdKafka\Conf;
use RdKafka\Producer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class BasicProducerCommand extends Command
{
    private const TOPIC = 'basic-topic';

    protected static $defaultName = 'kafka:basic:producer';

    public function configure(): void
    {
        $this->setDescription('Kafka producer example');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Start producer');

        $generalConfig = new Conf();
        $generalConfig->set('metadata.broker.list', 'php.kafka.broker:29092');

        $generalConfig->setErrorCb(function ($rk, $err, $reason) {
            printf("Kafka error: %s (reason: %s)\n", rd_kafka_err2str($err), $reason);
        });

        $producer = new Producer($generalConfig);

        $topic = $producer->newTopic(self::TOPIC);

        $output->writeln('Send messages');
        for ($i = 600; $i <= 640; ++$i) {
            $topic->produce(\RD_KAFKA_PARTITION_UA, 0, 'Message payload nº'.$i);
            $producer->poll(0);
        }

        for ($flushRetries = 0; $flushRetries < 10; ++$flushRetries) {
            $result = $producer->flush(100);
            if (\RD_KAFKA_RESP_ERR_NO_ERROR === $result) {
                break;
            }
        }

        $output->writeln('Finish OK');

        return 0;
    }
}
