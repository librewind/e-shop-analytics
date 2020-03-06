<?php

declare(strict_types=1);

namespace App\Sales\SalesGenerator;

use App\Sales\Entity\Customer;
use App\Sales\Entity\FactSale;
use App\Sales\Entity\Product;
use App\Sales\Entity\Promotion;
use App\Sales\Producer\FactSaleProducerInterface;
use Doctrine\ORM\EntityManagerInterface;

final class SalesGenerator implements SalesGeneratorInterface
{
    private const DISCOUNTS = [5, 10, 15, 20, 25];
    private const START_SALES_DATE = '2019-01-01';
    private const END_SALES__DATE = '2020-02-22';

    private EntityManagerInterface $entityManager;
    private FactSaleProducerInterface $producer;

    public function __construct(EntityManagerInterface $entityManager, FactSaleProducerInterface $producer)
    {
        $this->entityManager = $entityManager;
        $this->producer = $producer;
    }

    public function generate(int $salesCount): void
    {
        $customers = $this->entityManager->getRepository(Customer::class)->findAll();
        $products = $this->entityManager->getRepository(Product::class)->findAll();
        $promotions = $this->entityManager->getRepository(Promotion::class)->findAll();
        $customer = $this->getRandomArrayItem($customers);
        $promotion = $this->getRandomArrayItem($promotions);

        $saleDate = $this->generateRandomDate(self::START_SALES_DATE, self::END_SALES__DATE);
        $customerId = $customer->getId();
        $customerFirstName = $customer->getFirstName();
        $customerLastName = $customer->getLastName();
        $customerDateOfBirth = $customer->getDateOfBirth();
        $promotionId = $promotion->getId();
        $promotionName = $promotion->getName();

        for ($i = 0; $i < $salesCount; ++$i) {
            $product = $this->getRandomArrayItem($products);

            $factSale = new FactSale();
            $factSale->setDate($saleDate);
            $factSale->setCustomerId($customerId);
            $factSale->setCustomerFirstName($customerFirstName);
            $factSale->setCustomerLastName($customerLastName);
            $factSale->setCustomerDateOfBirth($customerDateOfBirth);
            $factSale->setProductId($product->getId());
            $factSale->setProductSku($product->getSku());
            $factSale->setProductName($product->getName());
            $factSale->setQuantity($this->generateRandomQuantity());
            $factSale->setNetPrice($this->calculateNetPrice($product->getPrice(), $factSale->getQuantity()));
            $factSale->setDiscountPrice($this->acceptRandomDiscount($factSale->getNetPrice()));
            $factSale->setPromotionId($promotionId);
            $factSale->setPromotionName($promotionName);

            $this->entityManager->persist($factSale);
            $this->entityManager->flush();

            $this->producer->produce($factSale);
        }
    }

    private function generateRandomDate(string $startDate, string $endDate): \DateTimeImmutable
    {
        $days = round((strtotime($endDate) - strtotime($startDate)) / (60 * 60 * 24));
        $randomOffsetInDays = rand(0, intval($days));

        return new \DateTimeImmutable(date("Y-m-d", strtotime("$startDate + $randomOffsetInDays days")));
    }

    private function acceptRandomDiscount(float $netPrice): float
    {
        $randomIndex = array_rand(self::DISCOUNTS);
        $randomDiscount = self::DISCOUNTS[$randomIndex];
        $discountPrice = $netPrice - $randomDiscount/100 * $netPrice;

        return floatval(round($discountPrice, 2));
    }

    private function getRandomArrayItem(array $array)
    {
        $maxIndex = count($array) - 1;
        $randomIndex = rand(0, $maxIndex);

        return $array[$randomIndex];
    }

    private function generateRandomQuantity(): int
    {
        return rand(1, 9);
    }

    private function calculateNetPrice(float $itemPrice, int $count): float
    {
        return floatval(round($itemPrice * $count, 2));
    }
}
