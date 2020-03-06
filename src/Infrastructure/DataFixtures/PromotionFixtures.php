<?php

declare(strict_types=1);

namespace App\Infrastructure\DataFixtures;

use App\Sales\Entity\Promotion;
use Bezhanov\Faker\Provider\Commerce;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

final class PromotionFixtures extends Fixture
{
    private const COUNT_PROMOTIONS = 100;

    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
        $this->faker->addProvider(new Commerce($this->faker));
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < self::COUNT_PROMOTIONS; ++$i) {
            $promotion = new Promotion();
            $promotion->setName($this->generateRandomPromotionName());
            $promotion->setDescription($this->generateRandomPromotionDescription());
            $manager->persist($promotion);
        }

        $manager->flush();
    }

    private function generateRandomPromotionName(): string
    {
        return $this->faker->promotionCode;
    }

    private function generateRandomPromotionDescription(): string
    {
        return $this->faker->paragraph;
    }
}
