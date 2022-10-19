<?php

declare(strict_types=1);

namespace App\Module\Cart\Domain\Entity;

use Assert\Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'carts')]
class Cart
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\OneToMany(mappedBy: 'cart', targetEntity: CartProduct::class,  cascade: ['persist', 'remove'])]
    /** @var Collection<CartProduct> */
    private Collection $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function addProduct(int $productId, int $quantity): self
    {
        $product = $this->getProductById($productId);

        if (null !== $product) {
            $product->addQuantity($quantity);
        } else {
            Assert::that($this->products->count() + 1)->max(3, 'You can add maximum 3 products to cart');

            $this->products->add(new CartProduct($this, $productId, $quantity));
        }

        return $this;
    }

    public function getProductById(int $productId): ?CartProduct
    {
        $cartProduct = $this->products->filter(function(CartProduct $cartProduct) use ($productId) {
            return $cartProduct->getProductId() === $productId;
        })->first();

        return !$cartProduct ? null : $cartProduct;
    }

    /**
     * @return Collection<CartProduct>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    /**
     * @return int[]
     */
    public function getProductIds(): array
    {
        $result = [];

        foreach ($this->products as $product) {
            $result[] = $product->getProductId();
        }

        return $result;
    }
}
