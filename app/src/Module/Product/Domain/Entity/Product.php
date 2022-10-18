<?php

declare(strict_types=1);

namespace App\Module\Product\Domain\Entity;

use App\Module\SharedKernel\ValueObject\Price;
use Assert\Assert;
use Doctrine\ORM\Mapping as ORM;
use Money\Money;

#[ORM\Entity]
#[ORM\Table(name: 'products')]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 255, unique: true)]
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

    public function setTitle(string $title): self
    {
        Assert::that($title)->betweenLength(1, 255);
        $this->title = $title;

        return $this;
    }

    public function getPrice(): Price
    {
        return $this->price;
    }

    public function setPrice(Price $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function updateNetAmount(int $amount): self
    {
        $this->price = new Price(
            new Money($amount, $this->price->getNetPrice()->getCurrency()),
            $this->price->getTaxRate(),
        );

        return $this;
    }
}
