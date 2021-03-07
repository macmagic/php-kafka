<?php

declare(strict_types=1);

namespace App\BasicExample\Ui\Command;

use RdKafka\Conf;
use RdKafka\Consumer;
use RdKafka\TopicConf;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class BasicConsumerStoredOffsetCommand extends Command
{
    private const TOPIC = 'basic-topic';

    protected static $defaultName = 'kafka:basic:consumer-offset-stored';

    public function configure(): void
    {
        $this->setDescription(sprintf('Command to consume message from topic %s', self::TOPIC));
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Consumer start');
        $generalConfig = new Conf();
        $generalConfig->set('group.id', 'app-stored');
        $generalConfig->set('metadata.broker.list', 'php.kafka.broker:29092');
        $generalConfig->set('enable.auto.commit', 'true');

        $consumer = new Consumer($generalConfig);

        $topicConfig = new TopicConf();
        $topicConfig->set('auto.commit.interval.ms', 100);
        $topicConfig->set('offset.store.method', 'file');
        $topicConfig->set('auto.offset.reset', 'smallest');
        $topicConfig->set('offset.store.path', __DIR__.'/../../../../data/kafka-offset.txt');

        $topic = $consumer->newTopic(self::TOPIC, $topicConfig);

        $topic->consumeStart(0, \RD_KAFKA_OFFSET_STORED);

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
            $topic->offsetStore($msg->partition, $msg->offset);
        }

        return 0;
    }
}
