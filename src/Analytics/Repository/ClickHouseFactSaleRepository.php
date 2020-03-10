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
        return $this->connection->fetchAll(
            'SELECT date, CAST(count(distinct(customer_id)) AS UInt32) AS count_customer FROM fact_sale WHERE promotion_id = :promotionId GROUP BY date ORDER BY date DESC',
            [
                'promotionId' => $promotionId,
            ],
            [
                'promotionId' => ParameterType::INTEGER,
            ]
        );
    }

    public function getCountSoldProductsPerDayByPromotionId(int $promotionId): array
    {
        return $this->connection->fetchAll(
            'SELECT date, CAST(sum(quantity) AS UInt32) AS count_sold_products FROM fact_sale WHERE promotion_id = :promotionId GROUP BY date ORDER BY date DESC',
            [
                'promotionId' => $promotionId,
            ],
            [
                'promotionId' => ParameterType::INTEGER,
            ]
        );
    }

    public function getNetSalesPerDay(): array
    {
        return $this->connection->fetchAll('SELECT date, CAST(sum(net_price) AS Decimal(14,2)) AS net_sales FROM fact_sale GROUP BY date ORDER BY date DESC');
    }
}
