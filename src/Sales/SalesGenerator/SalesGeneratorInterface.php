<?php

declare(strict_types=1);

namespace App\Sales\SalesGenerator;

interface SalesGeneratorInterface
{
    public function generate(int $salesCount): void;
}
