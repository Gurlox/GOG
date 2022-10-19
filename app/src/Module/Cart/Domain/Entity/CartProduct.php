<?php

declare(strict_types=1);

namespace App\Module\Cart\Domain\Entity;

use Assert\Assert;
use Assert\InvalidArgumentException;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'cart_products')]
class CartProduct
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\ManyToOne(targetEntity: Cart::class, inversedBy: 'products')]
    private Cart $cart;

    #[ORM\Column]
    private int $productId;

    #[ORM\Column]
    private int $quantity;

    public function __construct(
        Cart $cart,
        int $productId,
        int $quantity,
    ) {
        $this->cart = $cart;
        $this->productId = $productId;
        $this->setQuantity($quantity);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCart(): Cart
    {
        return $this->cart;
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->validateQuantity($quantity);
        $this->quantity = $quantity;

        return $this;
    }

    public function addQuantity(int $quantity): self
    {
        $newQuantity = $this->quantity + $quantity;
        $this->validateQuantity($newQuantity);
        $this->quantity = $newQuantity;

        return $this;
    }

    /**
     * @throws InvalidArgumentException
     */
    private function validateQuantity(int $quantity): void
    {
        Assert::lazy()
            ->that($quantity)
                ->min(1, 'Quantity minimal value should be 1')
                ->max(10, 'You can\'t add more than 10 units of the same product')
            ->verifyNow();
    }
}
