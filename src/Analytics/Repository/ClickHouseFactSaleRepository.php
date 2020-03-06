<?php

declare(strict_types=1);

namespace App\Analytics\Repository;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\ParameterType;

final class ClickHouseFactSaleRepository implements FactSaleRepositoryInterface
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function getCountUniqCustomersPerDayByPromotionId(int $promotionId): array
    {
        $result = $this->connection->fetchAll(
            'SELECT date, CAST(uniqCombined(customer_id) AS UInt32) AS count_customer FROM fact_sale WHERE promotion_id = :promotionId GROUP BY date ORDER BY date DESC',
            [
                'promotionId' => $promotionId,
            ],
            [
                'promotionId' => ParameterType::INTEGER,
            ]
        );

        return $result;
    }
}
