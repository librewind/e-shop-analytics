<?php

declare(strict_types=1);

namespace App\Infrastructure\Kafka;

use RdKafka\Conf;
use RdKafka\Producer;
use RdKafka\TopicConf;

final class RdKafkaProducer implements ProducerInterface
{
    private Producer $producer;

    public function __construct(array $kafkaParams)
    {
        $topicConf = new TopicConf();

        $conf = new Conf();
        $conf->set('metadata.broker.list', $kafkaParams['host'].':'.$kafkaParams['port']);
        $conf->set('group.id', $kafkaParams['group']);
        $conf->setDefaultTopicConf($topicConf);

        $this->producer = new Producer($conf);
    }

    public function send(string $topic, string $data): void
    {
        $topic = $this->producer->newTopic($topic, null);
        $topic->produce(RD_KAFKA_PARTITION_UA, 0 /* must be 0 */, $data, null);
    }
}
