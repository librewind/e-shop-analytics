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
        return $this->connection->fetchAll(
            'SELECT date, count(distinct(customer_id)) AS count_customer FROM fact_sale WHERE promotion_id = :promotionId GROUP BY date ORDER BY date DESC',
            [
                'promotionId' => $promotionId,
            ]
        );
    }

    public function getCountSoldProductsPerDayByPromotionId(int $promotionId): array
    {
        return $this->connection->fetchAll(
            'SELECT date, sum(quantity) AS count_sold_products FROM fact_sale WHERE promotion_id = :promotionId GROUP BY date ORDER BY date DESC',
            [
                'promotionId' => $promotionId,
            ]
        );
    }

    public function getNetSalesPerDay(): array
    {
        return $this->connection->fetchAll('SELECT date, sum(net_price)  AS net_sales FROM fact_sale GROUP BY date ORDER BY date DESC');
    }
}
