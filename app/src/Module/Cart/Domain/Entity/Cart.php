<?php

declare(strict_types=1);

namespace App\Module\Cart\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'carts')]
class Cart
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column]
    /** @var int[] */
    private array $products = [];

    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int[]
     */
    public function getProducts(): array
    {
        return $this->products;
    }
}
