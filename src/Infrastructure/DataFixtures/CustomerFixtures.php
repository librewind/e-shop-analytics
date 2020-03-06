<?php

declare(strict_types=1);

namespace App\Infrastructure\DataFixtures;

use App\Sales\Entity\Customer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

final class CustomerFixtures extends Fixture
{
    private const COUNT_CUSTOMERS = 1000;

    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < self::COUNT_CUSTOMERS; ++$i) {
            $customer = new Customer();
            $customer->setFirstName($this->generateRandomCustomerFirstName());
            $customer->setLastName($this->generateRandomCustomerLastName());
            $customer->setDateOfBirth($this->generateRandomCustomerDateOfBirth());
            $manager->persist($customer);
        }

        $manager->flush();
    }

    private function generateRandomCustomerFirstName(): string
    {
        return $this->faker->firstName;
    }

    private function generateRandomCustomerLastName(): string
    {
        return $this->faker->lastName;
    }

    private function generateRandomCustomerDateOfBirth(): \DateTimeImmutable
    {
        return new \DateTimeImmutable($this->faker->date('Y-m-d', '-18 years'));
    }
}
