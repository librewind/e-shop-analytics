<?php

declare(strict_types=1);

namespace App\Infrastructure\DataFixtures;

use App\Sales\Entity\Product;
use Bezhanov\Faker\Provider\Commerce;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

final class ProductFixtures extends Fixture
{
    private const COUNT_PRODUCTS = 500;

    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
        $this->faker->addProvider(new Commerce($this->faker));
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < self::COUNT_PRODUCTS; ++$i) {
            $product = new Product();
            $product->setSku($this->generateRandomSku());
            $product->setName($this->generateRandomProductName());
            $product->setDescription($this->generateRandomProductDescription());
            $product->setPrice($this->generateRandomPrice());
            $manager->persist($product);
        }

        $manager->flush();
    }

    private function generateRandomSku(): string
    {
        return strtoupper($this->faker->bothify('??###???'));
    }

    private function generateRandomProductName(): string
    {
        return $this->faker->productName;
    }

    private function generateRandomProductDescription(): string
    {
        return $this->faker->paragraph;
    }

    private function generateRandomPrice(): float
    {
        return floatval(rand(1, 9).rand(1, 9).'.'.rand(0, 9).rand(0, 9));
    }
}
