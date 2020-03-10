<?php

declare(strict_types=1);

namespace App\Analytics\Repository;

interface FactSaleRepositoryInterface
{
    public function getCountUniqCustomersPerDayByPromotionId(int $promotionId): array;

    public function getCountSoldProductsPerDayByPromotionId(int $promotionId): array;

    public function getNetSalesPerDay(): array;
}
