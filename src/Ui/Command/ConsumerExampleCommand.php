<?php

declare(strict_types=1);

namespace App\Ui\Command;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use RdKafka\Conf;
use RdKafka\Consumer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ConsumerExampleCommand extends Command
{
    private const TOPIC = 'topic';

    protected static $defaultName = 'kafka:example:consumer';

    public function configure(): void
    {
        $this->setDescription(sprintf('Command to consume message from topic %s', self::TOPIC));
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln("Consumer start");
        $generalConfig = new Conf();
        $generalConfig->set('group.id', 'app-test');
        $generalConfig->set('metadata.broker.list', 'php.kafka.broker:29092');
        $generalConfig->set('enable.auto.commit', 'true');

        $consumer = new Consumer($generalConfig);

        $topic = $consumer->newTopic(self::TOPIC);

        $topic->consumeStart(0, \RD_KAFKA_OFFSET_BEGINNING);


        while (true) {
            $msg = $topic->consume(0, 1000);
            if (null === $msg) {
                continue;
            }
            if ($msg->err) {
                $output->writeln($msg->errstr());
                break;
            }
            $output->writeln($msg->payload);
        }

        return 0;
    }
}
