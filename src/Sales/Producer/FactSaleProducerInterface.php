<?php

declare(strict_types=1);

namespace App\Sales\Producer;

use App\Sales\Entity\FactSale;

interface FactSaleProducerInterface
{
    public function produce(FactSale $factSale): void;
}
