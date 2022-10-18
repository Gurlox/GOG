<?php

declare(strict_types=1);

namespace App\Module\Product\Domain\Entity;

use App\Module\SharedKernel\ValueObject\Price;
use Assert\Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'products')]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 255)]
    private string $title;

    #[ORM\Column(type: 'price')]
    private Price $price;

    public function __construct(
        string $title,
        Price $price,
    ) {
        $this->setTitle($title);
        $this->price = $price;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        Assert::that($title)->betweenLength(1, 255);
        $this->title = $title;
    }

    public function getPrice(): Price
    {
        return $this->price;
    }

    public function setPrice(Price $price): void
    {
        $this->price = $price;
    }

}
