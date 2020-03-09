<?php

declare(strict_types=1);

namespace App\Analytics\Repository;

use Doctrine\DBAL\Connection;

final class PostgresFactSaleRepository implements FactSaleRepositoryInterface
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function getCountUniqCustomersPerDayByPromotionId(int $promotionId): array
    {
        $result = $this->connection->fetchAll(
            'SELECT date, count(distinct(customer_id)) AS count_customer FROM fact_sale WHERE promotion_id = :promotionId GROUP BY date ORDER BY date DESC',
            [
                'promotionId' => $promotionId,
            ]
        );

        return $result;
    }

    public function getCountSoldProductsPerDayByPromotionId(int $promotionId): array
    {
        $result = $this->connection->fetchAll(
            'SELECT date, sum(quantity) AS count_sold_products FROM fact_sale WHERE promotion_id = :promotionId GROUP BY date ORDER BY date DESC',
            [
                'promotionId' => $promotionId,
            ]
        );

        return $result;
    }
}
