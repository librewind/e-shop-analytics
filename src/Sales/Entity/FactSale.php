<?php

declare(strict_types=1);

namespace App\Sales\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(
 *     indexes={
 *         @ORM\Index(name="promotion_date_idx", columns={"promotion_id", "date"})
 *     }
 * )
 */
final class FactSale
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private int $id;

    /**
     * @ORM\Column(type="date_immutable")
     */
    private \DateTimeImmutable $date;

    /**
     * @ORM\Column(type="integer")
     */
    private int $customerId;

    /**
     * @ORM\Column
     */
    private string $customerFirstName;

    /**
     * @ORM\Column
     */
    private string $customerLastName;

    /**
     * @ORM\Column(type="date_immutable")
     */
    private \DateTimeImmutable $customerDateOfBirth;

    /**
     * @ORM\Column(type="integer")
     */
    private int $productId;

    /**
     * @ORM\Column
     */
    private string $productSku;

    /**
     * @ORM\Column
     */
    private string $productName;

    /**
     * @ORM\Column(type="integer")
     */
    private int $quantity;

    /**
     * @ORM\Column(type="float")
     */
    private float $netPrice;

    /**
     * @ORM\Column(type="float")
     */
    private float $discountPrice;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $promotionId;

    /**
     * @ORM\Column(nullable=true, nullable=true)
     */
    private ?string $promotionName;

    public function getId(): int
    {
        return $this->id;
    }

    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(\DateTimeImmutable $date): void
    {
        $this->date = $date;
    }

    public function getCustomerId(): int
    {
        return $this->customerId;
    }

    public function setCustomerId(int $customerId): void
    {
        $this->customerId = $customerId;
    }

    public function getCustomerFirstName(): string
    {
        return $this->customerFirstName;
    }

    public function setCustomerFirstName(string $customerFirstName): void
    {
        $this->customerFirstName = $customerFirstName;
    }

    public function getCustomerLastName(): string
    {
        return $this->customerLastName;
    }

    public function setCustomerLastName(string $customerLastName): void
    {
        $this->customerLastName = $customerLastName;
    }

    public function getCustomerDateOfBirth(): \DateTimeImmutable
    {
        return $this->customerDateOfBirth;
    }

    public function setCustomerDateOfBirth(\DateTimeImmutable $customerDateOfBirth): void
    {
        $this->customerDateOfBirth = $customerDateOfBirth;
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function setProductId(int $productId): void
    {
        $this->productId = $productId;
    }

    public function getProductSku(): string
    {
        return $this->productSku;
    }

    public function setProductSku(string $productSku): void
    {
        $this->productSku = $productSku;
    }

    public function getProductName(): string
    {
        return $this->productName;
    }

    public function setProductName(string $productName): void
    {
        $this->productName = $productName;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    public function getNetPrice(): float
    {
        return $this->netPrice;
    }

    public function setNetPrice(float $netPrice): void
    {
        $this->netPrice = $netPrice;
    }

    public function getDiscountPrice(): float
    {
        return $this->discountPrice;
    }

    public function setDiscountPrice(float $discountPrice): void
    {
        $this->discountPrice = $discountPrice;
    }

    public function getPromotionId(): ?int
    {
        return $this->promotionId;
    }

    public function setPromotionId(?int $promotionId): void
    {
        $this->promotionId = $promotionId;
    }

    public function getPromotionName(): ?string
    {
        return $this->promotionName;
    }

    public function setPromotionName(?string $promotionName): void
    {
        $this->promotionName = $promotionName;
    }
}
