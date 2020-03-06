<?php

declare(strict_types=1);

namespace App\Infrastructure\EventListener\Doctrine;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Tools\Event\GenerateSchemaEventArgs;

/**
 * @see https://github.com/doctrine/dbal/issues/1110#issuecomment-255765189
 */
final class PostgresqlSchemeFix implements EventSubscriber
{
    public function getSubscribedEvents()
    {
        return [
            'postGenerateSchema',
        ];
    }

    public function postGenerateSchema(GenerateSchemaEventArgs $args): void
    {
        $schema = $args->getSchema();

        if (!$schema->hasNamespace('public')) {
            $schema->createNamespace('public');
        }
    }
}
