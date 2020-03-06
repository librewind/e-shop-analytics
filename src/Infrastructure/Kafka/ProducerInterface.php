<?php

declare(strict_types=1);

namespace App\Infrastructure\Kafka;

interface ProducerInterface
{
    public function send(string $topic, string $data): void;
}
