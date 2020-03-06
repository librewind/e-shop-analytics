<?php

declare(strict_types=1);

namespace App\Sales\Producer;

use App\Infrastructure\Kafka\ProducerInterface;
use App\Sales\Entity\FactSale;

final class FactSaleProducer implements FactSaleProducerInterface
{
    private ProducerInterface $producer;

    public function __construct(ProducerInterface $producer)
    {
        $this->producer = $producer;
    }

    public function produce(FactSale $factSale): void
    {
        $this->producer->send('fact_sales', json_encode([
            'date' => $factSale->getDate()->format('Y-m-d'),
            'customer_id' => $factSale->getCustomerId(),
            'customer_first_name' => $factSale->getCustomerFirstName(),
            'customer_last_name' => $factSale->getCustomerLastName(),
            'customer_date_of_birth' => $factSale->getCustomerDateOfBirth()->format('Y-m-d'),
            'product_id' => $factSale->getProductId(),
            'product_sku' => $factSale->getProductSku(),
            'product_name' => $factSale->getProductName(),
            'quantity' => $factSale->getQuantity(),
            'net_price' => $factSale->getNetPrice(),
            'discount_price' => $factSale->getDiscountPrice(),
            'promotion_id' => $factSale->getPromotionId(),
            'promotion_name' => $factSale->getPromotionName()
        ]));
    }
}
